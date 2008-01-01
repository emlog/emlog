var FCKTools=new Object();
FCKTools.GetLinkedFieldValue=function()
{
	return FCK.LinkedField.value;
};
FCKTools.AttachToLinkedFieldFormSubmit=function(A)
{
	var B=FCK.LinkedField.form;
	if (!B) return;
	if (FCKBrowserInfo.IsIE) B.attachEvent("onsubmit",A);
	else B.addEventListener('submit',A,true);
	if (!B.updateFCKeditor) B.updateFCKeditor=new Array();
	B.updateFCKeditor[B.updateFCKeditor.length]=A;
	if (!B.originalSubmit&&(typeof(B.submit)=='function'||(!B.submit.tagName&&!B.submit.length)))
	{
		B.originalSubmit=B.submit;
		B.submit=FCKTools_SubmitReplacer;
	};
};
function FCKTools_SubmitReplacer()
{
	if (this.updateFCKeditor)
	{
		for (var i=0;i<this.updateFCKeditor.length;i++) this.updateFCKeditor[i]();
	};
	this.originalSubmit();
};
FCKTools.ConvertStyleSizeToHtml=function(A)
{
	return A.endsWith('%')?A:parseInt(A);
};
FCKTools.ConvertHtmlSizeToStyle=function(A)
{
	return A.endsWith('%')?A:(A+'px');
};
FCKTools._FixDocumentParentWindow=function(A)
{
	A.document.parentWindow=A;
	for (var i=0;i<A.frames.length;i++) FCKTools._FixDocumentParentWindow(A.frames[i]);
};
FCKTools.CancelEvent=function(e)
{
	return false;
};
FCKTools.AppendStyleSheet=function(A,B)
{
	return A.createStyleSheet(B);
};
FCKTools.CreateXmlObject=function(A)
{
	var B;
	switch (A)
	{
		case 'XmlHttp':B=['MSXML2.XmlHttp','Microsoft.XmlHttp'];
		break;
		case 'DOMDocument':B=['MSXML2.DOMDocument','Microsoft.XmlDom'];
		break;
	};
	for (var i=0;i<2;i++)
	{
		try
		{
			return new ActiveXObject(B[i]);
		}
		catch (e)
		{
		};
	};
	if (FCKLang.NoActiveX)
	{
		alert(FCKLang.NoActiveX);
		FCKLang.NoActiveX=null;
	};
};
FCKTools.DisableSelection=function(A)
{
	A.unselectable='on';
	var e,i=0;
	while (e=A.all[i++])
	{
		switch (e.tagName)
		{
			case 'IFRAME':case 'TEXTAREA':case 'INPUT':case 'SELECT':/* Ignore the above tags */ break;
			default:e.unselectable='on';
		};
	};
};
var FCKRegexLib=new Object();
FCKRegexLib.AposEntity=/&apos;/gi;
FCKRegexLib.ObjectElements=/^(?:IMG|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|HR|OBJECT|A|UL|OL|LI)$/i;
FCKRegexLib.BlockElements=/^(?:P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|OL|UL|LI|TD|TH)$/i;
FCKRegexLib.EmptyElements=/^(?:BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT)$/i;
FCKRegexLib.NamedCommands=/^(?:Unlink|Bold|Italic|Underline|JustifyLeft|JustifyCenter|JustifyRight|Outdent|Indent|InsertOrderedList|InsertUnorderedList|InsertHorizontalRule)$/i;
FCKRegexLib.BodyContents=/([\s\S]*\<body[^\>]*\>)([\s\S]*)(\<\/body\>[\s\S]*)/i;
FCKRegexLib.ToReplace=/___fcktoreplace:([\w]+)/ig;
FCKRegexLib.MetaHttpEquiv=/http-equiv\s*=\s*["']?([^"' ]+)/i;FCKRegexLib.HasBaseTag=/<base /i;FCKRegexLib.HeadOpener=/<head\s?[^>]*>/i;FCKRegexLib.HeadCloser=/<\/head\s*>/i;FCKRegexLib.TableBorderClass=/\s*FCK__ShowTableBorders\s*/;FCKRegexLib.ElementName=/^[A-Za-z_:][\w.\-:]*$/;FCKRegexLib.ForceSimpleAmpersand=/___FCKAmp___/g;FCKRegexLib.SpaceNoClose=/\/>/g;FCKRegexLib.EmptyParagraph=/^<(p|div)>\s*<\/\1>$/i;FCKRegexLib.TagBody=/></;FCKRegexLib.StrongOpener=/<STRONG([ \>])/gi;FCKRegexLib.StrongCloser=/<\/STRONG>/gi;FCKRegexLib.EmOpener=/<EM([ \>])/gi;FCKRegexLib.EmCloser=/<\/EM>/gi;FCKRegexLib.GeckoEntitiesMarker=/#\?-\:/g;FCKRegexLib.ProtectUrlsAApo=/(<a\s.*?href=)("|')(.+?)\2/gi;
FCKRegexLib.ProtectUrlsANoApo=/(<a\s.*?href=)([^"'][^ >]+)/gi;FCKRegexLib.ProtectUrlsImgApo=/(<img\s.*?src=)("|')(.+?)\2/gi;FCKRegexLib.ProtectUrlsImgNoApo=/(<img\s.*?src=)([^"'][^ >]+)/gi;
FCKLanguageManager.GetActiveLanguage=function()
{
	if (FCKConfig.AutoDetectLanguage)
	{
		var A;
		if (navigator.userLanguage) A=navigator.userLanguage.toLowerCase();
		else if (navigator.language) A=navigator.language.toLowerCase();
		else
		{
			return FCKConfig.DefaultLanguage;
		};
		if (A.length>=5)
		{
			A=A.substr(0,5);
			if (this.AvailableLanguages[A]) return A;
		};
		if (A.length>=2)
		{
			A=A.substr(0,2);
			if (this.AvailableLanguages[A]) return A;
		};
	};
	return this.DefaultLanguage;
};
FCKLanguageManager.TranslateElements=function(A,B,C)
{
	var e=A.getElementsByTagName(B);
	for (var i=0;i<e.length;i++)
	{
		var D=e[i].getAttribute('fckLang');
		if (D)
		{
			var s=FCKLang[D];
			if (s) eval('e[i].'+C+' = s');
		};
	};
};
FCKLanguageManager.TranslatePage=function(A)
{
	this.TranslateElements(A,'INPUT','value');
	this.TranslateElements(A,'SPAN','innerHTML');
	this.TranslateElements(A,'LABEL','innerHTML');
	this.TranslateElements(A,'OPTION','innerHTML');
};
if (FCKLanguageManager.AvailableLanguages[FCKConfig.DefaultLanguage]) FCKLanguageManager.DefaultLanguage=FCKConfig.DefaultLanguage;
else FCKLanguageManager.DefaultLanguage='en';
FCKLanguageManager.ActiveLanguage=new Object();
FCKLanguageManager.ActiveLanguage.Code=FCKLanguageManager.GetActiveLanguage();
FCKLanguageManager.ActiveLanguage.Name=FCKLanguageManager.AvailableLanguages[FCKLanguageManager.ActiveLanguage.Code];
FCK.Language=FCKLanguageManager;
LoadLanguageFile();
var FCKEvents;
if (!(FCKEvents=NS.FCKEvents))
{
	FCKEvents=NS.FCKEvents=function(A)
	{
		this.Owner=A;
		this.RegisteredEvents=new Object();
	};
	FCKEvents.prototype.AttachEvent=function(A,B)
	{
		if (!this.RegisteredEvents[A]) this.RegisteredEvents[A]=new Array();
		this.RegisteredEvents[A][this.RegisteredEvents[A].length]=B;
	};
	FCKEvents.prototype.FireEvent=function(A,B)
	{
		var C=true;
		var D=this.RegisteredEvents[A];
		if (D)
		{
			for (var i=0;i<D.length;i++) C=(D[i](this.Owner,B)&&C);
		};
		return C;
	};
}
var FCKXHtmlEntities=new Object();
if (FCKConfig.ProcessHTMLEntities)
{
	FCKXHtmlEntities.Entities=
	{
		' ':'nbsp','¡':'iexcl','¢':'cent','£':'pound','¤':'curren','¥':'yen','¦':'brvbar','§':'sect','¨':'uml','©':'copy','ª':'ordf','«':'laquo','¬':'not','­':'shy','®':'reg','¯':'macr','°':'deg','±':'plusmn','²':'sup2','³':'sup3','´':'acute','µ':'micro','¶':'para','·':'middot','¸':'cedil','¹':'sup1','º':'ordm','»':'raquo','¼':'frac14','½':'frac12','¾':'frac34','¿':'iquest','×':'times','÷':'divide','ƒ':'fnof','•':'bull','…':'hellip','′':'prime','″':'Prime','‾':'oline','⁄':'frasl','℘':'weierp','ℑ':'image','ℜ':'real','™':'trade','ℵ':'alefsym','←':'larr','↑':'uarr','→':'rarr','↓':'darr','↔':'harr','↵':'crarr','⇐':'lArr','⇑':'uArr','⇒':'rArr','⇓':'dArr','⇔':'hArr','∀':'forall','∂':'part','∃':'exist','∅':'empty','∇':'nabla','∈':'isin','∉':'notin','∋':'ni','∏':'prod','∑':'sum','−':'minus','∗':'lowast','√':'radic','∝':'prop','∞':'infin','∠':'ang','∧':'and','∨':'or','∩':'cap','∪':'cup','∫':'int','∴':'there4','∼':'sim','≅':'cong','≈':'asymp','≠':'ne','≡':'equiv','≤':'le','≥':'ge','⊂':'sub','⊃':'sup','⊄':'nsub','⊆':'sube','⊇':'supe','⊕':'oplus','⊗':'otimes','⊥':'perp','⋅':'sdot','◊':'loz','♠':'spades','♣':'clubs','♥':'hearts','♦':'diams','"':'quot','ˆ':'circ','˜':'tilde',' ':'ensp',' ':'emsp',' ':'thinsp','‌':'zwnj','‍':'zwj','‎':'lrm','‏':'rlm','–':'ndash','—':'mdash','‘':'lsquo','’':'rsquo','‚':'sbquo','“':'ldquo','”':'rdquo','„':'bdquo','†':'dagger','‡':'Dagger','‰':'permil','‹':'lsaquo','›':'rsaquo','€':'euro'
	};
	FCKXHtmlEntities.Chars='';
	for (var e in FCKXHtmlEntities.Entities) FCKXHtmlEntities.Chars+=e;if (FCKConfig.IncludeLatinEntities)
	{
		var oEntities=
		{
			'À':'Agrave','Á':'Aacute','Â':'Acirc','Ã':'Atilde','Ä':'Auml','Å':'Aring','Æ':'AElig','Ç':'Ccedil','È':'Egrave','É':'Eacute','Ê':'Ecirc','Ë':'Euml','Ì':'Igrave','Í':'Iacute','Î':'Icirc','Ï':'Iuml','Ð':'ETH','Ñ':'Ntilde','Ò':'Ograve','Ó':'Oacute','Ô':'Ocirc','Õ':'Otilde','Ö':'Ouml','Ø':'Oslash','Ù':'Ugrave','Ú':'Uacute','Û':'Ucirc','Ü':'Uuml','Ý':'Yacute','Þ':'THORN','ß':'szlig','à':'agrave','á':'aacute','â':'acirc','ã':'atilde','ä':'auml','å':'aring','æ':'aelig','ç':'ccedil','è':'egrave','é':'eacute','ê':'ecirc','ë':'euml','ì':'igrave','í':'iacute','î':'icirc','ï':'iuml','ð':'eth','ñ':'ntilde','ò':'ograve','ó':'oacute','ô':'ocirc','õ':'otilde','ö':'ouml','ø':'oslash','ù':'ugrave','ú':'uacute','û':'ucirc','ü':'uuml','ý':'yacute','þ':'thorn','ÿ':'yuml','Œ':'OElig','œ':'oelig','Š':'Scaron','š':'scaron','Ÿ':'Yuml'
		};
		for (var e in oEntities)
		{
			FCKXHtmlEntities.Entities[e]=oEntities[e];
			FCKXHtmlEntities.Chars+=e;
		};
		oEntities=null;
	};
	if (FCKConfig.IncludeGreekEntities)
	{
		var oEntities=
		{
			'Α':'Alpha','Β':'Beta','Γ':'Gamma','Δ':'Delta','Ε':'Epsilon','Ζ':'Zeta','Η':'Eta','Θ':'Theta','Ι':'Iota','Κ':'Kappa','Λ':'Lambda','Μ':'Mu','Ν':'Nu','Ξ':'Xi','Ο':'Omicron','Π':'Pi','Ρ':'Rho','Σ':'Sigma','Τ':'Tau','Υ':'Upsilon','Φ':'Phi','Χ':'Chi','Ψ':'Psi','Ω':'Omega','α':'alpha','β':'beta','γ':'gamma','δ':'delta','ε':'epsilon','ζ':'zeta','η':'eta','θ':'theta','ι':'iota','κ':'kappa','λ':'lambda','μ':'mu','ν':'nu','ξ':'xi','ο':'omicron','π':'pi','ρ':'rho','ς':'sigmaf','σ':'sigma','τ':'tau','υ':'upsilon','φ':'phi','χ':'chi','ψ':'psi','ω':'omega'
		};
		for (var e in oEntities)
		{
			FCKXHtmlEntities.Entities[e]=oEntities[e];
			FCKXHtmlEntities.Chars+=e;
		};
		oEntities=null;
	};
	FCKXHtmlEntities.EntitiesRegex=new RegExp('['+FCKXHtmlEntities.Chars+']|[^'+FCKXHtmlEntities.Chars+']+','g');
}
else
{
	FCKXHtmlEntities.Entities=
	{
		' ':'nbsp'
	};
	FCKXHtmlEntities.EntitiesRegex=/[ ]|[^ ]+/g;
}
var FCKXHtml=new Object();
FCKXHtml.CurrentJobNum=0;
FCKXHtml.GetXHTML=function(A,B,C)
{
	FCKXHtml.SpecialBlocks=new Array();
	this.XML=FCKTools.CreateXmlObject('DOMDocument');
	this.MainNode=this.XML.appendChild(this.XML.createElement('xhtml'));
	FCKXHtml.CurrentJobNum++;
	if (B) this._AppendNode(this.MainNode,A);
	else this._AppendChildNodes(this.MainNode,A,false);
	var D=this._GetMainXmlString();
	D=D.substr(7,D.length-15).trim();
	if (FCKBrowserInfo.IsGecko) D=D.replace(/<br\/>$/,'');
	D=D.replace(FCKRegexLib.SpaceNoClose,' />');
	if (FCKConfig.ForceSimpleAmpersand) D=D.replace(FCKRegexLib.ForceSimpleAmpersand,'&');
	if (C) D=FCKCodeFormatter.Format(D);
	for (var i=0;i<FCKXHtml.SpecialBlocks.length;i++)
	{
		var E=new RegExp('___FCKsi___'+i);
		D=D.replace(E,FCKXHtml.SpecialBlocks[i]);
	};
	this.XML=null;
	return D
};
FCKXHtml._AppendAttribute=function(A,B,C)
{
	try
	{
		var D=this.XML.createAttribute(B);
		D.value=C?C:'';
		A.attributes.setNamedItem(D);
	}
	catch (e)
	{
	};
};
FCKXHtml._AppendChildNodes=function(A,B,C)
{
	var D=0;
	var E=B.firstChild;
	while (E)
	{
		if (this._AppendNode(A,E)) D++;
		E=E.nextSibling;
	};
	if (D==0)
	{
		if (C&&FCKConfig.FillEmptyBlocks)
		{
			this._AppendEntity(A,'nbsp');
			return;
		};
		if (!FCKRegexLib.EmptyElements.test(B.nodeName)) A.appendChild(this.XML.createTextNode(''));
	};
};
FCKXHtml._AppendNode=function(A,B)
{
	if (!B) return;
	switch (B.nodeType)
	{
		case 1:if (B.getAttribute('_fckfakelement')) return FCKXHtml._AppendNode(A,FCK.GetRealElement(B));
		if (FCKBrowserInfo.IsGecko&&B.hasAttribute('_moz_editor_bogus_node')) return false;
		if (B.getAttribute('_fckdelete')) return false;
		var C=B.nodeName;
		if (FCKBrowserInfo.IsIE&&B.scopeName&&B.scopeName!='HTML') C=B.scopeName+':'+C;
		if (!FCKRegexLib.ElementName.test(C)) return false;
		C=C.toLowerCase();
		if (FCKBrowserInfo.IsGecko&&C=='br'&&B.hasAttribute('type')&&B.getAttribute('type',2)=='_moz') return false;
		if (B._fckxhtmljob&&B._fckxhtmljob==FCKXHtml.CurrentJobNum) return false;
		var D=this._CreateNode(C);
		FCKXHtml._AppendAttributes(A,B,D,C);
		B._fckxhtmljob=FCKXHtml.CurrentJobNum;
		var E=FCKXHtml.TagProcessors[C];
		if (E)
		{
			D=E(D,B);
			if (!D) break;
		}
		else this._AppendChildNodes(D,B,FCKRegexLib.BlockElements.test(C));
		A.appendChild(D);
		break;
		case 3:this._AppendTextNode(A,B.nodeValue.replaceNewLineChars(' '));
		break;
		case 8:try
		{
			A.appendChild(this.XML.createComment(B.nodeValue));
		}
		catch (e)
		{
		};
		break;
		default:A.appendChild(this.XML.createComment("Element not supported - Type: "+B.nodeType+" Name: "+B.nodeName));
		break;
	};
	return true;
};
if (FCKConfig.ForceStrongEm)
{
	FCKXHtml._CreateNode=function(A)
	{
		switch (A)
		{
			case 'b':A='strong';
			break;
			case 'i':A='em';
			break;
		};
		return this.XML.createElement(A);
	};
}
else
{
	FCKXHtml._CreateNode=function(A)
	{
		return this.XML.createElement(A);
	};
};
FCKXHtml._AppendSpecialItem=function(A)
{
	return '___FCKsi___'+FCKXHtml.SpecialBlocks.addItem(A);
};
FCKXHtml._AppendTextNode=function(A,B)
{
	var C=B.match(FCKXHtmlEntities.EntitiesRegex);
	if (C)
	{
		for (var i=0;i<C.length;i++)
		{
			if (C[i].length==1)
			{
				var D=FCKXHtmlEntities.Entities[C[i]];
				if (D!=null)
				{
					this._AppendEntity(A,D);
					continue;
				};
			};
			A.appendChild(this.XML.createTextNode(C[i]));
		};
	};
};
FCKXHtml.TagProcessors=new Object();
FCKXHtml.TagProcessors['img']=function(A,B)
{
	if (!A.attributes.getNamedItem('alt')) FCKXHtml._AppendAttribute(A,'alt','');
	var C=B.getAttribute('_fcksavedurl');
	if (C&&C.length>0) FCKXHtml._AppendAttribute(A,'src',C);
	return A;
};
FCKXHtml.TagProcessors['a']=function(A,B)
{
	var C=B.getAttribute('_fcksavedurl');
	if (C&&C.length>0) FCKXHtml._AppendAttribute(A,'href',C);
	FCKXHtml._AppendChildNodes(A,B,false);
	return A;
};
FCKXHtml.TagProcessors['script']=function(A,B)
{
	if (!A.attributes.getNamedItem('type')) FCKXHtml._AppendAttribute(A,'type','text/javascript');
	A.appendChild(FCKXHtml.XML.createTextNode(FCKXHtml._AppendSpecialItem(B.text)));
	return A;
};
FCKXHtml.TagProcessors['style']=function(A,B)
{
	if (B.getAttribute('_fcktemp')) return null;
	if (!A.attributes.getNamedItem('type')) FCKXHtml._AppendAttribute(A,'type','text/css');
	A.appendChild(FCKXHtml.XML.createTextNode(FCKXHtml._AppendSpecialItem(B.innerHTML)));
	return A;
};
FCKXHtml.TagProcessors['title']=function(A,B)
{
	A.appendChild(FCKXHtml.XML.createTextNode(FCK.EditorDocument.title));
	return A;
};
FCKXHtml.TagProcessors['base']=function(A,B)
{
	if (B.getAttribute('_fcktemp')) return null;
	return A;
};
FCKXHtml.TagProcessors['link']=function(A,B)
{
	if (B.getAttribute('_fcktemp')) return null;
	return A;
};
FCKXHtml.TagProcessors['table']=function(A,B)
{
	var C=A.attributes.getNamedItem('class');
	if (C&&FCKRegexLib.TableBorderClass.test(C.nodeValue))
	{
		var D=C.nodeValue.replace(FCKRegexLib.TableBorderClass,'');
		if (D.length==0) A.attributes.removeNamedItem('class');
		else FCKXHtml._AppendAttribute(A,'class',D);
	};
	FCKXHtml._AppendChildNodes(A,B,false);
	return A;
}
FCKXHtml._GetMainXmlString=function()
{
	return this.MainNode.xml;
};
FCKXHtml._AppendEntity=function(A,B)
{
	A.appendChild(this.XML.createEntityReference(B));
};
FCKXHtml._AppendAttributes=function(A,B,C,D)
{
	var E=B.attributes;
	for (var n=0;n<E.length;n++)
	{
		var F=E[n];
		if (F.specified)
		{
			var G=F.nodeName.toLowerCase();
			var H;
			if (G.startsWith('_fck')) continue;
			else if (G=='style') H=B.style.cssText;
			else if (G=='class'||G.indexOf('on')==0) H=F.nodeValue;
			else if (D=='body'&&G=='contenteditable') continue;
			else if (F.nodeValue===true) H=G;
			else if (!(H=B.getAttribute(G,2))) H=F.nodeValue;
			if (FCKConfig.ForceSimpleAmpersand&&H.replace) H=H.replace(/&/g,'___FCKAmp___');
			this._AppendAttribute(C,G,H);
		};
	};
};
FCKXHtml.TagProcessors['meta']=function(A,B)
{
	var C=A.attributes.getNamedItem('http-equiv');
	if (C==null||C.value.length==0)
	{
		var D=B.outerHTML.match(FCKRegexLib.MetaHttpEquiv);
		if (D)
		{
			D=D[1];
			FCKXHtml._AppendAttribute(A,'http-equiv',D);
		};
	};
	return A;
};
FCKXHtml.TagProcessors['font']=function(A,B)
{
	if (A.attributes.length==0) A=FCKXHtml.XML.createDocumentFragment();
	FCKXHtml._AppendChildNodes(A,B);
	return A;
};
FCKXHtml.TagProcessors['input']=function(A,B)
{
	if (B.name) FCKXHtml._AppendAttribute(A,'name',B.name);
	if (B.value&&!A.attributes.getNamedItem('value')) FCKXHtml._AppendAttribute(A,'value',B.value);
	return A;
};
FCKXHtml.TagProcessors['option']=function(A,B)
{
	if (B.selected&&!A.attributes.getNamedItem('selected')) FCKXHtml._AppendAttribute(A,'selected','selected');
	FCKXHtml._AppendChildNodes(A,B);
	return A;
};
FCKXHtml.TagProcessors['area']=function(A,B)
{
	if (!A.attributes.getNamedItem('coords'))
	{
		var C=B.getAttribute('coords',2);
		if (C&&C!='0,0,0') FCKXHtml._AppendAttribute(A,'coords',C);
	};
	if (!A.attributes.getNamedItem('shape'))
	{
		var C=B.getAttribute('shape',2);
		if (C&&C.length>0) FCKXHtml._AppendAttribute(A,'shape',C);
	};
	return A;
};
FCKXHtml.TagProcessors['label']=function(A,B)
{
	if (B.htmlFor.length>0) FCKXHtml._AppendAttribute(A,'for',B.htmlFor);
	FCKXHtml._AppendChildNodes(A,B);
	return A;
};
FCKXHtml.TagProcessors['form']=function(A,B)
{
	if (B.acceptCharset&&B.acceptCharset.length>0&&B.acceptCharset!='UNKNOWN') FCKXHtml._AppendAttribute(A,'accept-charset',B.acceptCharset);
	if (B.name) FCKXHtml._AppendAttribute(A,'name',B.name);
	FCKXHtml._AppendChildNodes(A,B);
	return A;
};
FCKXHtml.TagProcessors['textarea']=FCKXHtml.TagProcessors['select']=function(A,B)
{
	if (B.name) FCKXHtml._AppendAttribute(A,'name',B.name);
	FCKXHtml._AppendChildNodes(A,B);
	return A;
};
FCKXHtml.TagProcessors['div']=function(A,B)
{
	if (B.align.length>0) FCKXHtml._AppendAttribute(A,'align',B.align);
	FCKXHtml._AppendChildNodes(A,B);
	return A;
}
var FCKCodeFormatter;
if (!(FCKCodeFormatter=NS.FCKCodeFormatter))
{
	FCKCodeFormatter=NS.FCKCodeFormatter=new Object();
	FCKCodeFormatter.Regex=new Object();
	FCKCodeFormatter.Regex.BlocksOpener=/\<(P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|OL|UL|LI|TITLE|META|LINK|BASE|SCRIPT|LINK|TD|TH|AREA|OPTION)[^\>]*\>/gi;
	FCKCodeFormatter.Regex.BlocksCloser=/\<\/(P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|OL|UL|LI|TITLE|META|LINK|BASE|SCRIPT|LINK|TD|TH|AREA|OPTION)[^\>]*\>/gi;
	FCKCodeFormatter.Regex.NewLineTags=/\<(BR|HR)[^\>]\>/gi;
	FCKCodeFormatter.Regex.MainTags=/\<\/?(HTML|HEAD|BODY|FORM|TABLE|TBODY|THEAD|TR)[^\>]*\>/gi;
	FCKCodeFormatter.Regex.LineSplitter=/\s*\n+\s*/g;
	FCKCodeFormatter.Regex.IncreaseIndent=/^\<(HTML|HEAD|BODY|FORM|TABLE|TBODY|THEAD|TR|UL|OL)[ \/\>]/i;
	FCKCodeFormatter.Regex.DecreaseIndent=/^\<\/(HTML|HEAD|BODY|FORM|TABLE|TBODY|THEAD|TR|UL|OL)[ \>]/i;
	FCKCodeFormatter.Regex.FormatIndentatorRemove=new RegExp(FCKConfig.FormatIndentator);
	FCKCodeFormatter.Regex.ProtectedTags=/(<PRE[^>]*>)([\s\S]*?)(<\/PRE>)/gi;
	FCKCodeFormatter._ProtectData=function(A,B,C,D)
	{
		return B+'___FCKpd___'+FCKCodeFormatter.ProtectedData.addItem(C)+D;
	};
	FCKCodeFormatter.Format=function(A)
	{
		FCKCodeFormatter.ProtectedData=new Array();
		var B=A.replace(this.Regex.ProtectedTags,FCKCodeFormatter._ProtectData);
		B=B.replace(this.Regex.BlocksOpener,'\n$&');;
		B=B.replace(this.Regex.BlocksCloser,'$&\n');
		B=B.replace(this.Regex.NewLineTags,'$&\n');
		B=B.replace(this.Regex.MainTags,'\n$&\n');
		var C='';
		var D=B.split(this.Regex.LineSplitter);
		B='';
		for (var i=0;i<D.length;i++)
		{
			var E=D[i];
			if (E.length==0) continue;
			if (this.Regex.DecreaseIndent.test(E)) C=C.replace(this.Regex.FormatIndentatorRemove,'');
			B+=C+E+'\n';
			if (this.Regex.IncreaseIndent.test(E)) C+=FCKConfig.FormatIndentator;
		};
		for (var i=0;i<FCKCodeFormatter.ProtectedData.length;i++)
		{
			var F=new RegExp('___FCKpd___'+i);
			B=B.replace(F,FCKCodeFormatter.ProtectedData[i]);
		};
		return B.trim();
	};
}
var FCK_StartupValue;
FCK.Events=new FCKEvents(FCK);
FCK.Toolbar=null;
FCK.TempBaseTag=FCKConfig.BaseHref.length>0?'<base href="'+FCKConfig.BaseHref+'" _fcktemp="true"></base>':'';
FCK.StartEditor=function()
{
	this.EditorWindow=window.frames['eEditorArea'];
	this.EditorDocument=this.EditorWindow.document;
	this.SetHTML(FCKTools.GetLinkedFieldValue());
	this.ResetIsDirty();
	FCKTools.AttachToLinkedFieldFormSubmit(this.UpdateLinkedField);
	this.SetStatus(FCK_STATUS_ACTIVE);
};
function Window_OnFocus()
{
	FCK.Focus();
	FCK.Events.FireEvent("OnFocus");
};
function Window_OnBlur()
{
	if (!FCKDialog.IsOpened) return FCK.Events.FireEvent("OnBlur");
};
FCK.SetStatus=function(A)
{
	this.Status=A;
	if (A==FCK_STATUS_ACTIVE)
	{
		window.frameElement.onfocus=window.document.body.onfocus=Window_OnFocus;
		window.frameElement.onblur=Window_OnBlur;
		if (FCKConfig.StartupFocus) FCK.Focus();
		if (FCKBrowserInfo.IsIE) FCKScriptLoader.AddScript('js/fckeditorcode_ie_2.js');
		else FCKScriptLoader.AddScript('js/fckeditorcode_gecko_2.js');
	};
	this.Events.FireEvent('OnStatusChange',A);
};
FCK.GetHTML=function(A)
{
	FCK.GetXHTML(A);
};
FCK.GetXHTML=function(A)
{
	var B=(FCK.EditMode==FCK_EDITMODE_SOURCE);
	if (B) this.SwitchEditMode();
	var C;
	if (FCKConfig.FullPage) C=FCKXHtml.GetXHTML(this.EditorDocument.getElementsByTagName('html')[0],true,A);
	else
	{
		if (FCKConfig.IgnoreEmptyParagraphValue&&this.EditorDocument.body.innerHTML=='<P>&nbsp;</P>') C='';
		else C=FCKXHtml.GetXHTML(this.EditorDocument.body,false,A);
	};
	if (B) this.SwitchEditMode();
	if (FCKBrowserInfo.IsIE) C=C.replace(FCKRegexLib.ToReplace,'$1');
	if (FCK.DocTypeDeclaration&&FCK.DocTypeDeclaration.length>0) C=FCK.DocTypeDeclaration+'\n'+C;
	if (FCK.XmlDeclaration&&FCK.XmlDeclaration.length>0) C=FCK.XmlDeclaration+'\n'+C;
	return FCKConfig.ProtectedSource.Revert(C);
};
FCK.UpdateLinkedField=function()
{
	FCK.LinkedField.value=FCK.GetXHTML(FCKConfig.FormatOutput);
	FCK.Events.FireEvent('OnAfterLinkedFieldUpdate');
};
FCK.RegisteredDoubleClickHandlers=new Object();
FCK.OnDoubleClick=function(A)
{
	var B=FCK.RegisteredDoubleClickHandlers[A.tagName];
	if (B) B(A);
};
FCK.OnAfterSetHTML=function()
{
	var A,i=0;
	while((A=FCKDocumentProcessors[i++])) A.ProcessDocument(FCK.EditorDocument);
	this.Events.FireEvent('OnAfterSetHTML');
};
FCK.ProtectUrls=function(A)
{
	A=A.replace(FCKRegexLib.ProtectUrlsAApo,'$1$2$3$2 _fcksavedurl=$2$3$2');
	A=A.replace(FCKRegexLib.ProtectUrlsANoApo,'$1$2 _fcksavedurl="$2"');
	A=A.replace(FCKRegexLib.ProtectUrlsImgApo,'$1$2$3$2 _fcksavedurl=$2$3$2');
	A=A.replace(FCKRegexLib.ProtectUrlsImgNoApo,'$1$2 _fcksavedurl="$2"');
	return A;
};
FCK.IsDirty=function()
{
	return (FCK_StartupValue!=FCK.EditorDocument.body.innerHTML);
};
FCK.ResetIsDirty=function()
{
	if (FCK.EditorDocument.body) FCK_StartupValue=FCK.EditorDocument.body.innerHTML;
};
var FCKDocumentProcessors=new Array();
var FCKDocumentProcessors_CreateFakeImage=function(A,B)
{
	var C=FCK.EditorDocument.createElement('IMG');
	C.className=A;
	C.src=FCKConfig.FullBasePath+'images/spacer.gif';
	C.setAttribute('_fckfakelement','true',0);
	C.setAttribute('_fckrealelement',FCKTempBin.AddElement(B),0);
	return C;
};
var FCKMediaProcessor=new Object();
FCKMediaProcessor.ProcessDocument=function(A)
{
	var B=A.getElementsByTagName('EMBED');
	var C;
	var i=B.length-1;
	while (i>=0&&(C=B[i--]))
	{
		if (C.src.endsWith('.swf',true))
		{
			var D=C.cloneNode(true);
			if (FCKBrowserInfo.IsIE)
			{
				D.setAttribute('play',C.getAttribute('play'));
				D.setAttribute('loop',C.getAttribute('loop'));
			};
			var E=FCKDocumentProcessors_CreateFakeImage('FCK__Media',D);
			E.setAttribute('_fckmeida','true',0);
			FCKMediaProcessor.RefreshView(E,C);
			C.parentNode.insertBefore(E,C);
			C.parentNode.removeChild(C);
		};
	};
};
FCKMediaProcessor.RefreshView=function(A,B)
{
	if (B.width>0) A.style.width=FCKTools.ConvertHtmlSizeToStyle(B.width);
	if (B.height>0) A.style.height=FCKTools.ConvertHtmlSizeToStyle(B.height);
};
FCKDocumentProcessors.addItem(FCKMediaProcessor);
FCK.GetRealElement=function(A)
{
	var e=FCKTempBin.Elements[A.getAttribute('_fckrealelement')];
	if (A.getAttribute('_fckmedia'))
	{
		if (A.style.width.length>0) e.width=FCKTools.ConvertStyleSizeToHtml(A.style.width);
		if (A.style.height.length>0) e.height=FCKTools.ConvertStyleSizeToHtml(A.style.height);
	};
	return e;
};
FCK.Description="FCKeditor for Internet Explorer 5.5+";
FCK._BehaviorsStyle='<style type="text/css" _fcktemp="true">\ INPUT { behavior:url(' + FCKConfig.FullBasePath + 'css/behaviors/hiddenfield.htc);} ';
if (FCKConfig.ShowBorders) FCK._BehaviorsStyle+='TABLE { behavior: url('+FCKConfig.FullBasePath+'css/behaviors/showtableborders.htc) ; }';
var sNoHandlers='INPUT, TEXTAREA, SELECT';
if (FCKConfig.DisableImageHandles) sNoHandlers+=', IMG';
FCK._BehaviorsStyle+=sNoHandlers+' { behavior: url('+FCKConfig.FullBasePath+'css/behaviors/disablehandles.htc) ; }';
FCK._BehaviorsStyle+='</style>';
function Doc_OnMouseUp()
{
	if (FCK.EditorWindow.event.srcElement.tagName=='HTML')
	{
		FCK.Focus();
		FCK.EditorWindow.event.cancelBubble=true;
		FCK.EditorWindow.event.returnValue=false;
	};
};
function Doc_OnDblClick()
{
	FCK.OnDoubleClick(FCK.EditorWindow.event.srcElement);
	FCK.EditorWindow.event.cancelBubble=true;
};
function Doc_OnSelectionChange()
{
	FCK.Events.FireEvent("OnSelectionChange");
};
FCK.InitializeBehaviors=function(A)
{
	this.EditorDocument.attachEvent('onmouseup',Doc_OnMouseUp);
	if (FCKConfig.TabSpaces>0)
	{
		window.FCKTabHTML='';
		for (i=0;i<FCKConfig.TabSpaces;i++) window.FCKTabHTML+="&nbsp;";
	};
	this.EditorDocument.attachEvent("ondblclick",Doc_OnDblClick);
	this.EditorDocument.attachEvent("onselectionchange",Doc_OnSelectionChange);
};
FCK.Focus=function()
{
	try
	{
		if (FCK.EditMode==FCK_EDITMODE_WYSIWYG) FCK.EditorDocument.body.focus();
		else document.getElementById('eSourceField').focus();
	}
	catch(e)
	{
	};
};
FCK.SetHTML=function(A,B)
{
	if (B||FCK.EditMode==FCK_EDITMODE_WYSIWYG)
	{
		A=FCKConfig.ProtectedSource.Protect(A);
		A=FCK.ProtectUrls(A);
		var C;
		if (FCKConfig.FullPage)
		{
			var C=FCK._BehaviorsStyle+'<link href="'+FCKConfig.FullBasePath+'css/fck_internal.css'+'" rel="stylesheet" type="text/css" _fcktemp="true" />';
			if (FCK.TempBaseTag.length>0&&!FCKRegexLib.HasBaseTag.test(A)) C+=FCK.TempBaseTag;
			C=A.replace(FCKRegexLib.HeadOpener,'$&'+C);
		}
		else
		{
			C=FCKConfig.DocType+'<html dir="'+FCKConfig.ContentLangDirection+'"';
			if (FCKConfig.IEForceVScroll) C+=' style="overflow-y: scroll"';
			C+='><head><title></title>'+'<link href="'+FCKConfig.EditorAreaCSS+'" rel="stylesheet" type="text/css" />'+'<link href="'+FCKConfig.FullBasePath+'css/fck_internal.css'+'" rel="stylesheet" type="text/css" _fcktemp="true" />';
			C+=FCK._BehaviorsStyle;
			C+=FCK.TempBaseTag;
			C+='</head><body>'+A+'</body></html>';
		};
		this.EditorDocument.open('','replace');
		this.EditorDocument.write(C);
		this.EditorDocument.close();
		this.InitializeBehaviors();
		this.EditorDocument.body.contentEditable=true;
		FCK.OnAfterSetHTML();
	}
	else document.getElementById('eSourceField').value=A;
};
FCK.InsertHtml=function(A)
{
	A=FCKConfig.ProtectedSource.Protect(A);
	A=FCK.ProtectUrls(A);
	FCK.Focus();
	var B=FCK.EditorDocument.selection;
	if (B.type.toLowerCase()!="none") B.clear();
	B.createRange().pasteHTML(A);
};
FCK.SetInnerHtml=function(A)
{
	var B=FCK.EditorDocument;
	B.body.innerHTML='<div id="__fakeFCKRemove__">&nbsp;</div>'+A;
	B.getElementById('__fakeFCKRemove__').removeNode(true);
}
