FCK.RedirectNamedCommands=new Object();
FCK.ExecuteNamedCommand=function(A,B,C)
{
	if (!C&&FCK.RedirectNamedCommands[A]!=null) FCK.ExecuteRedirectedNamedCommand(A,B);
	else
	{
		FCK.Focus();
		FCK.EditorDocument.execCommand(A,false,B);
		FCK.Events.FireEvent('OnSelectionChange');
	};
};
FCK.GetNamedCommandState=function(A)
{
	try
	{
		if (!FCK.EditorDocument.queryCommandEnabled(A)) return FCK_TRISTATE_DISABLED;
		else return FCK.EditorDocument.queryCommandState(A)?FCK_TRISTATE_ON:FCK_TRISTATE_OFF;
	}
	catch (e)
	{
		return FCK_TRISTATE_OFF;
	};
};
FCK.SwitchEditMode=function()
{
	var A=(FCK.EditMode==FCK_EDITMODE_WYSIWYG);
	document.getElementById('eWysiwyg').style.display=A?'none':'';
	document.getElementById('eSource').style.display=A?'':'none';
	if (A)
	{
		document.getElementById('eSourceField').value=FCK.GetXHTML(FCKConfig.FormatSource);
	}
	else FCK.SetHTML(document.getElementById('eSourceField').value,true);
	FCK.EditMode=A?FCK_EDITMODE_SOURCE:FCK_EDITMODE_WYSIWYG;
	FCKToolbarSet.RefreshModeState();
	FCK.Focus();
};
FCK.CreateElement=function(A)
{
	var e=FCK.EditorDocument.createElement(A);
	return FCK.InsertElementAndGetIt(e);
};
FCK.InsertElementAndGetIt=function(e)
{
	e.setAttribute('__FCKTempLabel',1);
	this.InsertElement(e);
	var A=FCK.EditorDocument.getElementsByTagName(e.tagName);
	for (var i=0;i<A.length;i++)
	{
		if (A[i].getAttribute('__FCKTempLabel'))
		{
			A[i].removeAttribute('__FCKTempLabel');
			return A[i];
		};
	};
	return null;
};
FCK.InsertElement=function(A)
{
	FCK.InsertHtml(A.outerHTML);
};
FCK.AttachToOnSelectionChange=function(A)
{
	this.Events.AttachEvent('OnSelectionChange',A);
};
FCK.CreateLink=function(A)
{
	FCK.ExecuteNamedCommand('Unlink');
	if (A.length>0)
	{
		var B='javascript:void(0);/*'+(new Date().getTime())+'*/';
		FCK.ExecuteNamedCommand('CreateLink',B);
		var C=this.EditorDocument.links;
		for (i=0;i<C.length;i++)
		{
			if (C[i].href==B)
			{
				C[i].href=A;
				return C[i];
			};
		};
	};
};
var FCKSelection=new Object();
FCK.Selection=FCKSelection;
FCKSelection.GetType=function()
{
	return FCK.EditorDocument.selection.type;
};
FCKSelection.GetSelectedElement=function()
{
	if (this.GetType()=='Control')
	{
		var A=FCK.EditorDocument.selection.createRange();
		if (A&&A.item) return FCK.EditorDocument.selection.createRange().item(0);
	};
};
FCKSelection.GetParentElement=function()
{
	switch (this.GetType())
	{
		case 'Control':return FCKSelection.GetSelectedElement().parentElement;
		case 'None':return;
		default:return FCK.EditorDocument.selection.createRange().parentElement();
	};
};
FCKSelection.SelectNode=function(A)
{
	FCK.Focus();
	FCK.EditorDocument.selection.empty();
	var B=FCK.EditorDocument.selection.createRange();
	B.moveToElementText(A);
	B.select();
};
FCKSelection.Collapse=function(A)
{
	FCK.Focus();
	var B=FCK.EditorDocument.selection.createRange();
	B.collapse(A==null||A===true);
	B.select();
};
FCKSelection.HasAncestorNode=function(A)
{
	var B;
	if (FCK.EditorDocument.selection.type=="Control")
	{
		B=this.GetSelectedElement();
	}
	else
	{
		var C=FCK.EditorDocument.selection.createRange();
		B=C.parentElement();
	};
	while (B)
	{
		if (B.tagName==A) return true;
		B=B.parentNode;
	};
	return false;
};
FCKSelection.MoveToAncestorNode=function(A)
{
	var B;
	if (FCK.EditorDocument.selection.type=="Control")
	{
		var C=FCK.EditorDocument.selection.createRange();
		for (i=0;i<C.length;i++)
		{
			if (C(i).parentNode)
			{
				B=C(i).parentNode;
				break;
			};
		};
	}
	else
	{
		var C=FCK.EditorDocument.selection.createRange();
		B=C.parentElement();
	};
	while (B&&B.nodeName!=A) B=B.parentNode;
	return B;
};
FCKSelection.Delete=function()
{
	var A=FCK.EditorDocument.selection;
	if (A.type.toLowerCase()!="none")
	{
		A.clear();
	};
	return A;
};
var FCKPanel=function(A)
{
	this.IsRTL=false;
	this.IsContextMenu=false;
	this._IsOpened=false;
	this._Window=A?A:window;
	this._Popup=this._Window.createPopup();
	this.Document=this._Popup.document;
	this.PanelDiv=this.Document.body.appendChild(this.Document.createElement('DIV'));
	this.PanelDiv.className='FCK_Panel';
	this.EnableContextMenu(false);
	this.SetDirection(FCKLang.Dir);
};
FCKPanel.prototype.EnableContextMenu=function(A)
{
	this.Document.oncontextmenu=A?null:FCKTools.CancelEvent;
};
FCKPanel.prototype.AppendStyleSheet=function(A)
{
	FCKTools.AppendStyleSheet(this.Document,A);
};
FCKPanel.prototype.SetDirection=function(A)
{
	this.IsRTL=(A=='rtl');
	this.Document.dir=A;
};
FCKPanel.prototype.Load=function(x,y,A)
{
	this._Popup.show(x,y,0,0,A);
};
FCKPanel.prototype.Show=function(x,y,A,B,C)
{
	this.Load(x,y,A);
	this.PanelDiv.style.width=B?B+'px':'';
	this.PanelDiv.style.height=C?C+'px':'';
	if (this.IsRTL)
	{
		if (this.IsContextMenu) x=x-this.PanelDiv.offsetWidth+1;
		else if (A) x=x+(A.offsetWidth-this.PanelDiv.offsetWidth);
	};
	this._Popup.show(x,y,this.PanelDiv.offsetWidth,this.PanelDiv.offsetHeight,A);
	if (this._OnHide)
	{
		if (FCKPanel_ActivePopupInfo.Timer) CheckPopupOnHide();
		FCKPanel_ActivePopupInfo.Timer=window.setInterval(CheckPopupOnHide,200);
		FCKPanel_ActivePopupInfo.Panel=this;
	};
	this._IsOpened=true;
};
FCKPanel.prototype.Hide=function()
{
	this._Popup.hide();
};
FCKPanel.prototype.CheckIsOpened=function()
{
	return this._Popup.isOpen;
};
FCKPanel.prototype.AttachToOnHideEvent=function(A)
{
	this._OnHide=A;
};
var FCKPanel_ActivePopupInfo=new Object();
function CheckPopupOnHide()
{
	var oPanel=FCKPanel_ActivePopupInfo.Panel;
	if (oPanel&&!oPanel._Popup.isOpen)
	{
		window.clearInterval(FCKPanel_ActivePopupInfo.Timer);
		if (oPanel._OnHide) oPanel._OnHide(oPanel);
		FCKPanel_ActivePopupInfo.Timer=null;
		FCKPanel_ActivePopupInfo.Panel=null;
	};
}
var FCKNamedCommand=function(A)
{
	this.Name=A;
};
FCKNamedCommand.prototype.Execute=function()
{
	FCK.ExecuteNamedCommand(this.Name);
};
FCKNamedCommand.prototype.GetState=function()
{
	return FCK.GetNamedCommandState(this.Name);
};
var FCKDialogCommand=function(A,B,C,D,E,F,G)
{
	this.Name=A;
	this.Title=B;
	this.Url=C;
	this.Width=D;
	this.Height=E;
	this.GetStateFunction=F;
	this.GetStateParam=G;
};
FCKDialogCommand.prototype.Execute=function()
{
	FCKDialog.OpenDialog('FCKDialog_'+this.Name,this.Title,this.Url,this.Width,this.Height);
};
FCKDialogCommand.prototype.GetState=function()
{
	if (this.GetStateFunction) return this.GetStateFunction(this.GetStateParam);
	else return FCK_TRISTATE_OFF;
};
var FCKUndefinedCommand=function()
{
	this.Name='Undefined';
};
FCKUndefinedCommand.prototype.Execute=function()
{
	alert(FCKLang.NotImplemented);
};
FCKUndefinedCommand.prototype.GetState=function()
{
	return FCK_TRISTATE_OFF;
};
var FCKSourceCommand=function()
{
	this.Name='Source';
};
FCKSourceCommand.prototype.Execute=function()
{
	if (FCKBrowserInfo.IsGecko)
	{
		var A=FCKConfig.ScreenWidth*0.65;
		var B=FCKConfig.ScreenHeight*0.65;
		FCKDialog.OpenDialog('FCKDialog_Source',FCKLang.Source,'dialog/fck_source.html',A,B,null,null,true);
	}
	else FCK.SwitchEditMode();
};
FCKSourceCommand.prototype.GetState=function()
{
	return (FCK.EditMode==FCK_EDITMODE_WYSIWYG?FCK_TRISTATE_OFF:FCK_TRISTATE_ON);
};
////////////////////////////////////
// PhpCode hack by angel 4ngel@21cn.com
////////////////////////////////////
var FCKPhpCommand = function()
{
	this.Name = 'Php' ;
}
FCKPhpCommand.prototype.Execute = function()
{
	var PhpCode = FCK.EditorDocument.selection.createRange().htmlText;
	FCK.InsertHtml('[break]') ;
}
FCKPhpCommand.prototype.GetState = function()
{
	return FCK_TRISTATE_OFF;
}
////////////////////////////////////
var FCKTextColorCommand=function(A)
{
	this.Name=A=='TextColor';
	this.Type=A;
	this._Panel=new FCKPanel();
	this._Panel.AppendStyleSheet(FCKConfig.SkinPath+'fck_contextmenu.css');
	this._CreatePanelBody(this._Panel.Document,this._Panel.PanelDiv);
	FCKTools.DisableSelection(this._Panel.Document.body);
};
FCKTextColorCommand.prototype.Execute=function(A,B,C)
{
	FCK._ActiveColorPanelType=this.Type;
	this._Panel.Show(A,B,C);
};
FCKTextColorCommand.prototype.SetColor=function(A)
{
	if (FCK._ActiveColorPanelType=='ForeColor') FCK.ExecuteNamedCommand('ForeColor',A);
	else if (FCKBrowserInfo.IsGecko) FCK.ExecuteNamedCommand('hilitecolor',A);
	delete FCK._ActiveColorPanelType;
};
FCKTextColorCommand.prototype.GetState=function()
{
	return FCK_TRISTATE_OFF;
};
function FCKTextColorCommand_OnMouseOver()
{
	this.className='ColorSelected';
};
function FCKTextColorCommand_OnMouseOut()
{
	this.className='ColorDeselected';
};
function FCKTextColorCommand_OnClick()
{
	this.className='ColorDeselected';
	this.Command.SetColor('#'+this.Color);
	this.Command._Panel.Hide();
};
function FCKTextColorCommand_AutoOnClick()
{
	this.className='ColorDeselected';
	this.Command.SetColor('');
	this.Command._Panel.Hide();
};
FCKTextColorCommand.prototype._CreatePanelBody=function(A,B)
{
	function CreateSelectionDiv()
	{
		var C=A.createElement("DIV");
		C.className='ColorDeselected';
		C.onmouseover=FCKTextColorCommand_OnMouseOver;
		C.onmouseout=FCKTextColorCommand_OnMouseOut;
		return C;
	};
	var D=B.appendChild(A.createElement("TABLE"));
	D.className='ForceBaseFont';
	D.style.tableLayout='fixed';
	D.cellPadding=0;
	D.cellSpacing=0;
	D.border=0;
	D.width=150;
	var E=D.insertRow(-1).insertCell(-1);
	E.colSpan=8;
	var C=E.appendChild(CreateSelectionDiv());
	C.innerHTML=FCKLang.ColorAutomatic;
	C.Command=this;
	C.onclick=FCKTextColorCommand_AutoOnClick;
	var G=FCKConfig.FontColors.toString().split(',');
	var H=0;
	while (H<G.length)
	{
		var I=D.insertRow(-1);
		for (var i=0;i<8&&H<G.length;i++,H++)
		{
			C=I.insertCell(-1).appendChild(CreateSelectionDiv());
			C.Color=G[H];
			C.innerHTML='<div class="ColorBoxBorder"><div class="ColorBox" style="background-color: #'+G[H]+'"></div></div>';
			C.Command=this;
			C.onclick=FCKTextColorCommand_OnClick;
		};
	};
}
var FCKCommands=FCK.Commands=new Object();
FCKCommands.LoadedCommands=new Object();
FCKCommands.RegisterCommand=function(A,B)
{
this.LoadedCommands[A]=B;
};
FCKCommands.GetCommand=function(A)
{
var B=FCKCommands.LoadedCommands[A];
if (B) return B;
switch (A)
{
	case 'Link':B=new FCKDialogCommand('Link',FCKLang.DlgLnkWindowTitle,'dialog/fck_link.html',400,240,FCK.GetNamedCommandState,'CreateLink');
	break;
	case 'About':B=new FCKDialogCommand('About',FCKLang.About,'dialog/fck_about.html',400,220);
	break;
	case 'Image':B=new FCKDialogCommand('Image',FCKLang.DlgImgTitle,'dialog/fck_image.html',450,260);
	break;
	case 'Media':B=new FCKDialogCommand('Media',FCKLang.DlgMediaTitle,'dialog/fck_media.html',450,220);
	break;
	case 'Table':B=new FCKDialogCommand('Table',FCKLang.DlgTableTitle,'dialog/fck_table.html',400,250);
	break;
	case 'Source':B=new FCKSourceCommand();
	break;
	case 'TextColor':B=new FCKTextColorCommand('ForeColor');
	break;
	case 'Php':B=new FCKPhpCommand();
	break;
	case 'Undefined':B=new FCKUndefinedCommand();
	break;
	default:if (FCKRegexLib.NamedCommands.test(A)) B=new FCKNamedCommand(A);
	else
	{
		alert(FCKLang.UnknownCommand.replace(/%1/g,A));
		return null;
	};
};
FCKCommands.LoadedCommands[A]=B;
	return B;
};
var FCKToolbarButton=function(A,B,C,D,E,F)
{
	this.Command=FCKCommands.GetCommand(A);
	this.Label=B?B:A;
	this.Tooltip=C?C:(B?B:A);
	this.SourceView=E?true:false;
	this.ContextSensitive=F?true:false;
	this.IconPath=FCKConfig.SkinPath+'toolbar/'+A.toLowerCase()+'.gif';
	this.State=FCK_UNKNOWN;
};
FCKToolbarButton.prototype.CreateInstance=function(A)
{
	this.DOMDiv=document.createElement('div');
	this.DOMDiv.className='TB_Button_Off';
	this.DOMDiv.FCKToolbarButton=this;
	this.DOMDiv.innerHTML='<img alt="'+this.Label+'" src="'+this.IconPath+'" width="21" height="21">';
	var C=A.DOMRow.insertCell(-1);
	C.appendChild(this.DOMDiv);
	this.RefreshState();
};
FCKToolbarButton.prototype.RefreshState=function()
{
	var A=this.Command.GetState();
	if (A==this.State) return;
	this.State=A;
	switch (this.State)
	{
		case FCK_TRISTATE_ON:this.DOMDiv.className='TB_Button_On';
		this.DOMDiv.onmouseover=FCKToolbarButton_OnMouseOnOver;
		this.DOMDiv.onmouseout=FCKToolbarButton_OnMouseOnOut;
		this.DOMDiv.onclick=FCKToolbarButton_OnClick;
		break;
		case FCK_TRISTATE_OFF:this.DOMDiv.className='TB_Button_Off';
		this.DOMDiv.onmouseover=FCKToolbarButton_OnMouseOffOver;
		this.DOMDiv.onmouseout=FCKToolbarButton_OnMouseOffOut;
		this.DOMDiv.onclick=FCKToolbarButton_OnClick;
		break;
		default:this.Disable();
		break;
	};
};
function FCKToolbarButton_OnMouseOnOver()
{
	this.className='TB_Button_On TB_Button_On_Over';
};
function FCKToolbarButton_OnMouseOnOut()
{
	this.className='TB_Button_On';
};
function FCKToolbarButton_OnMouseOffOver()
{
	this.className='TB_Button_On TB_Button_Off_Over';
};
function FCKToolbarButton_OnMouseOffOut()
{
	this.className='TB_Button_Off';
};
function FCKToolbarButton_OnClick(e)
{
	this.FCKToolbarButton.Click(e);
	return false;
};
FCKToolbarButton.prototype.Click=function()
{
	this.Command.Execute();
};
FCKToolbarButton.prototype.Enable=function()
{
	this.RefreshState();
};
FCKToolbarButton.prototype.Disable=function()
{
	this.State=FCK_TRISTATE_DISABLED;
	this.DOMDiv.className='TB_Button_Disabled';
	this.DOMDiv.onmouseover=null;
	this.DOMDiv.onmouseout=null;
	this.DOMDiv.onclick=null;
}
var FCKToolbarPanelButton=function(A,B,C,D)
{
	this.Command=FCKCommands.GetCommand(A);
	this.Label=B?B:A;
	this.Tooltip=C?C:(B?B:A);
	this.State=FCK_UNKNOWN;
	this.IconPath=FCKConfig.SkinPath+'toolbar/'+A.toLowerCase()+'.gif';
};
FCKToolbarPanelButton.prototype.Click=function(e)
{
	if (this.State!=FCK_TRISTATE_DISABLED)
	{
		this.Command.Execute(0,this.DOMDiv.offsetHeight,this.DOMDiv);
	};
	return false;
};
FCKToolbarPanelButton.prototype.CreateInstance=function(A)
{
	this.DOMDiv=document.createElement('div');
	this.DOMDiv.className='TB_Button_Off';
	this.DOMDiv.FCKToolbarButton=this;
	this.DOMDiv.innerHTML='<img alt="'+this.Label+'" title="'+this.Label+'" src="'+this.IconPath+'" width="21" height="21">';
	var C=A.DOMRow.insertCell(-1);
	C.appendChild(this.DOMDiv);
	this.RefreshState();
};
FCKToolbarPanelButton.prototype.RefreshState=FCKToolbarButton.prototype.RefreshState;
FCKToolbarPanelButton.prototype.Enable=FCKToolbarButton.prototype.Enable;
FCKToolbarPanelButton.prototype.Disable=FCKToolbarButton.prototype.Disable;
var FCKToolbarItems=new Object();
FCKToolbarItems.LoadedItems=new Object();
FCKToolbarItems.RegisterItem=function(A,B)
{
	this.LoadedItems[A]=B;
};
FCKToolbarItems.GetItem=function(A)
{
	var B=FCKToolbarItems.LoadedItems[A];
	if (B) return B;
	switch (A)
	{
		case 'Source':B=new FCKToolbarButton('Source',FCKLang.Source,null,null,true,true);
		break;
		case 'About':B=new FCKToolbarButton('About',FCKLang.About,null,null,true);
		break;
		case 'Bold':B=new FCKToolbarButton('Bold',FCKLang.Bold,null,null,false,true);
		break;
		case 'Italic':B=new FCKToolbarButton('Italic',FCKLang.Italic,null,null,false,true);
		break;
		case 'Underline':B=new FCKToolbarButton('Underline',FCKLang.Underline,null,null,false,true);
		break;
		case 'OrderedList':B=new FCKToolbarButton('InsertOrderedList',FCKLang.NumberedListLbl,FCKLang.NumberedList,null,false,true);
		break;
		case 'UnorderedList':B=new FCKToolbarButton('InsertUnorderedList',FCKLang.BulletedListLbl,FCKLang.BulletedList,null,false,true);
		break;
		case 'Outdent':B=new FCKToolbarButton('Outdent',FCKLang.DecreaseIndent,null,null,false,true);
		break;
		case 'Indent':B=new FCKToolbarButton('Indent',FCKLang.IncreaseIndent,null,null,false,true);
		break;
		case 'Link':B=new FCKToolbarButton('Link',FCKLang.InsertLinkLbl,FCKLang.InsertLink,null,false,true);
		break;
		case 'Unlink':B=new FCKToolbarButton('Unlink',FCKLang.RemoveLink,null,null,false,true);
		break;
		case 'Image':B=new FCKToolbarButton('Image',FCKLang.InsertImageLbl,FCKLang.InsertImage);
		break;
		case 'Media':B=new FCKToolbarButton('Media',FCKLang.InsertMediaLbl,FCKLang.InsertMedia);
		break;
		case 'Table':B=new FCKToolbarButton('Table',FCKLang.InsertTableLbl,FCKLang.InsertTable);
		break;
		case 'Rule':B=new FCKToolbarButton('InsertHorizontalRule',FCKLang.InsertLineLbl,FCKLang.InsertLine,null,false,true);
		break;
		case 'Php':B=new FCKToolbarButton('Php',FCKLang.InsertPhp,null,null,false,true);
		break;
		case 'JustifyLeft':B=new FCKToolbarButton('JustifyLeft',FCKLang.LeftJustify,null,null,false,true);
		break;
		case 'JustifyCenter':B=new FCKToolbarButton('JustifyCenter',FCKLang.CenterJustify,null,null,false,true);
		break;
		case 'JustifyRight':B=new FCKToolbarButton('JustifyRight',FCKLang.RightJustify,null,null,false,true);
		break;
		case 'TextColor':B=new FCKToolbarPanelButton('TextColor',FCKLang.TextColor);
		break;
		default:alert(FCKLang.UnknownToolbarItem.replace(/%1/g,A));
		return null;
	};
	FCKToolbarItems.LoadedItems[A]=B;
	return B;
}
var FCKToolbar=function()
{
	this.Items=new Array();
	var e=this.DOMTable=document.createElement('table');
	e.className='TB_Toolbar';
	e.style.styleFloat=e.style.cssFloat=FCKLang.Dir=='rtl'?'right':'left';
	e.cellPadding=0;
	e.cellSpacing=0;
	e.border=0;
	this.DOMRow=e.insertRow(-1);
	var A=this.DOMRow.insertCell(-1);
	A.className='TB_Start';
	A.innerHTML='<img src="'+FCKConfig.SkinPath+'images/toolbar.start.gif" width="7" height="21" style="VISIBILITY: hidden" onload="this.style.visibility = \'\';">';
	FCKToolbarSet.DOMElement.appendChild(e);
};
FCKToolbar.prototype.AddItem=function(A)
{
	this.Items[this.Items.length]=A;
	A.CreateInstance(this);
};
var FCKToolbarSet=FCK.ToolbarSet=new Object();
FCKToolbarSet.Toolbars=new Array();
FCKToolbarSet.ItemsWysiwygOnly=new Array();
FCKToolbarSet.ItemsContextSensitive=new Array();
FCKToolbarSet.Load=function(A)
{
	this.DOMElement=document.getElementById('eToolbar');
	var B=FCKConfig.ToolbarSets[A];
	if (!B)
	{
		alert(FCKLang.UnknownToolbarSet.replace(/%1/g,A));
		return;
	};
	this.Toolbars=new Array();
	for (var x=0;x<B.length;x++)
	{
		var C=B[x];
		var D=new FCKToolbar();
		for (var j=0;j<C.length;j++)
		{
			var E=C[j];
			var F=FCKToolbarItems.GetItem(E);
			if (F)
			{
				D.AddItem(F);
				if (!F.SourceView) this.ItemsWysiwygOnly[this.ItemsWysiwygOnly.length]=F;
				if (F.ContextSensitive) this.ItemsContextSensitive[this.ItemsContextSensitive.length]=F;
			};
		};
		this.Toolbars[this.Toolbars.length]=D;
	};
};
FCKToolbarSet.RefreshModeState=function()
{
	if (FCK.EditMode==FCK_EDITMODE_WYSIWYG)
	{
		for (var i=0;i<FCKToolbarSet.ItemsWysiwygOnly.length;i++) FCKToolbarSet.ItemsWysiwygOnly[i].Enable();
		FCKToolbarSet.RefreshItemsState();
	}
	else
	{
		FCKToolbarSet.RefreshItemsState();
		for (var i=0;i<FCKToolbarSet.ItemsWysiwygOnly.length;i++) FCKToolbarSet.ItemsWysiwygOnly[i].Disable();
	};
};
FCKToolbarSet.RefreshItemsState=function()
{
	for (var i=0;i<FCKToolbarSet.ItemsContextSensitive.length;i++) FCKToolbarSet.ItemsContextSensitive[i].RefreshState();
};
var FCKDialog=new Object();
FCKDialog.OpenDialog=function(A,B,C,D,E,F,G,H)
{
	var I=new Object();
	I.Title=B;
	I.Page=C;
	I.Editor=window;
	I.CustomValue=F;
	var J=FCKConfig.BasePath+'fckdialog.html';
	this.Show(I,A,J,D,E,G,H);
};
FCKDialog.Show=function(A,B,C,D,E,F)
{
	if (!F) F=window;
	this.IsOpened=true;
	F.showModalDialog(C,A,"dialogWidth:"+D+"px;dialogHeight:"+E+"px;help:no;scroll:no;status:no");
	this.IsOpened=false;
};
if (FCKLang&&window.document.dir.toLowerCase()!=FCKLang.Dir.toLowerCase()) window.document.dir=FCKLang.Dir;
CompleteLoading();
function CompleteLoading()
{
	FCKToolbarSet.Name=FCKURLParams['Toolbar']||'Default';
	FCKToolbarSet.Load(FCKToolbarSet.Name);
	FCK.AttachToOnSelectionChange(FCKToolbarSet.RefreshItemsState);
	FCKTools.DisableSelection(document.body);
	FCK.SetStatus(FCK_STATUS_COMPLETE);
	if (typeof(window.parent.FCKeditor_OnComplete)=='function') window.parent.FCKeditor_OnComplete(FCK);
}
