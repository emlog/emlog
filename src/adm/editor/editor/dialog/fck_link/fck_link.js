var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;

//#### Regular Expressions library.
var oRegex = new Object() ;

oRegex.UriProtocol = new RegExp('') ;
oRegex.UriProtocol.compile( '^(((http|https|ftp|news):\/\/)|mailto:)', 'gi' ) ;

oRegex.UrlOnChangeProtocol = new RegExp('') ;
oRegex.UrlOnChangeProtocol.compile( '^(http|https|ftp|news)://(?=.)', 'gi' ) ;

oRegex.UrlOnChangeTestOther = new RegExp('') ;
//oRegex.UrlOnChangeTestOther.compile( '^(javascript:|#|/)', 'gi' ) ;
oRegex.UrlOnChangeTestOther.compile( '^((javascript:)|[#/\.])', 'gi' ) ; 

oRegex.ReserveTarget = new RegExp('') ;
oRegex.ReserveTarget.compile( '^_(blank|self|top|parent)$', 'i' ) ;

//#### Initialization Code

// oLink: The actual selected link in the editor.
var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
if ( oLink )
	FCK.Selection.SelectNode( oLink ) ;

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	// Load the selected link information (if any).
	LoadSelection() ;

	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
}

function LoadSelection()
{
	if ( !oLink ) return ;

	var sType = 'url' ;

	// Get the actual Link href.
	var sHRef = oLink.getAttribute( '_fcksavedurl' ) ;
	if ( !sHRef || sHRef.length == 0 )
		sHRef = oLink.getAttribute( 'href' , 2 ) + '' ;
	// TODO: Wait stable version and remove the following commented lines.
//	if ( sHRef.startsWith( FCK.BaseUrl ) )
//		sHRef = sHRef.remove( 0, FCK.BaseUrl.length ) ;

	// Search for the protocol.
	var sProtocol = oRegex.UriProtocol.exec( sHRef ) ;

	if ( sProtocol )
	{
		sProtocol = sProtocol[0].toLowerCase() ;
		GetE('cmbLinkProtocol').value = sProtocol ;
		// Remove the protocol and get the remainig URL.
		var sUrl = sHRef.replace( oRegex.UriProtocol, '' ) ;
		sType = 'url' ;
		GetE('txtUrl').value = sUrl ;
	}
	else					// It is another type of link.
	{
		sType = 'url' ;
		GetE('cmbLinkProtocol').value = '' ;
		GetE('txtUrl').value = sHRef ;
	}

	// Get the target.
	var sTarget = oLink.target ;

	if ( sTarget && sTarget.length > 0 )
	{
		if ( oRegex.ReserveTarget.test( sTarget ) )
		{
			sTarget = sTarget.toLowerCase() ;
			GetE('cmbTarget').value = sTarget ;
		}
		else
		GetE('cmbTarget').value = 'frame' ;
	
		GetE('txtTargetFrame').value = sTarget ;
	}
}

//#### Target type selection.
function SetTarget( targetType )
{
	GetE('tdTargetFrame').style.display	= '' ;
	switch ( targetType )
	{
		case "_blank" :
		case "_self" :
		case "_parent" :
		case "_top" :
			GetE('txtTargetFrame').value = targetType ;
			break ;
		case "" :
			GetE('txtTargetFrame').value = '' ;
			break ;
	}
}

//#### Called while the user types the URL.
function OnUrlChange()
{
	var sUrl = GetE('txtUrl').value ;
	var sProtocol = oRegex.UrlOnChangeProtocol.exec( sUrl ) ;

	if ( sProtocol )
	{
		sUrl = sUrl.substr( sProtocol[0].length ) ;
		GetE('txtUrl').value = sUrl ;
		GetE('cmbLinkProtocol').value = sProtocol[0].toLowerCase() ;
	}
	else if ( oRegex.UrlOnChangeTestOther.test( sUrl ) )
	{
		GetE('cmbLinkProtocol').value = '' ;
	}
}

//#### Called while the user types the target name.
function OnTargetNameChange()
{
	var sFrame = GetE('txtTargetFrame').value ;

	if ( sFrame.length == 0 )
		GetE('cmbTarget').value = '' ;
	else if ( oRegex.ReserveTarget.test( sFrame ) )
		GetE('cmbTarget').value = sFrame.toLowerCase() ;
	else
		GetE('cmbTarget').value = 'frame' ;
}

//#### The OK button was hit.
function Ok()
{
	var sUri ;

	sUri = GetE('txtUrl').value ;
	if ( sUri.length == 0 )
	{
		alert( FCKLang.DlnLnkMsgNoUrl ) ;
		return false ;
	}
	sUri = GetE('cmbLinkProtocol').value + sUri ;

	if ( oLink )	// Modifying an existent link.
	{
		oLink.href = sUri ;
	}
	else			// Creating a new link.
	{
		oLink = oEditor.FCK.CreateLink( sUri ) ;
		if ( ! oLink )
			return true ;
	}

	SetAttribute( oLink, '_fcksavedurl', sUri ) ;

	// Target
	SetAttribute( oLink, 'target', GetE('txtTargetFrame').value ) ;

	return true ;
}