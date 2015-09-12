mw.loader.implement("jquery.client",function($,jQuery){(function($){var profileCache={};$.client={profile:function(nav){if(nav===undefined){nav=window.navigator;}if(profileCache[nav.userAgent+'|'+nav.platform]!==undefined){return profileCache[nav.userAgent+'|'+nav.platform];}var versionNumber,key=nav.userAgent+'|'+nav.platform,uk='unknown',x='x',wildUserAgents=['Opera','Navigator','Minefield','KHTML','Chrome','PLAYSTATION 3','Iceweasel'],userAgentTranslations=[[/(Firefox|MSIE|KHTML,?\slike\sGecko|Konqueror)/,''],['Chrome Safari','Chrome'],['KHTML','Konqueror'],['Minefield','Firefox'],['Navigator','Netscape'],['PLAYSTATION 3','PS3']],versionPrefixes=['camino','chrome','firefox','iceweasel','netscape','netscape6','opera','version','konqueror','lynx','msie','safari','ps3','android'],versionSuffix='(\\/|\\;?\\s|)([a-z0-9\\.\\+]*?)(\\;|dev|rel|\\)|\\s|$)',names=['camino','chrome','firefox','iceweasel','netscape','konqueror','lynx','msie','opera','safari','ipod','iphone','blackberry','ps3',
'rekonq','android'],nameTranslations=[],layouts=['gecko','konqueror','msie','trident','opera','webkit'],layoutTranslations=[['konqueror','khtml'],['msie','trident'],['opera','presto']],layoutVersions=['applewebkit','gecko','trident'],platforms=['win','wow64','mac','linux','sunos','solaris','iphone'],platformTranslations=[['sunos','solaris'],['wow64','win']],translate=function(source,translations){var i;for(i=0;i<translations.length;i++){source=source.replace(translations[i][0],translations[i][1]);}return source;},ua=nav.userAgent,match,name=uk,layout=uk,layoutversion=uk,platform=uk,version=x;if(match=new RegExp('('+wildUserAgents.join('|')+')').exec(ua)){ua=translate(ua,userAgentTranslations);}ua=ua.toLowerCase();if(match=new RegExp('('+names.join('|')+')').exec(ua)){name=translate(match[1],nameTranslations);}if(match=new RegExp('('+layouts.join('|')+')').exec(ua)){layout=translate(match[1],layoutTranslations);}if(match=new RegExp('('+layoutVersions.join('|')+')\\\/(\\d+)').exec(ua)){
layoutversion=parseInt(match[2],10);}if(match=new RegExp('('+platforms.join('|')+')').exec(nav.platform.toLowerCase())){platform=translate(match[1],platformTranslations);}if(match=new RegExp('('+versionPrefixes.join('|')+')'+versionSuffix).exec(ua)){version=match[3];}if(name==='safari'&&version>400){version='2.0';}if(name==='opera'&&version>=9.8){match=ua.match(/\bversion\/([0-9\.]*)/);if(match&&match[1]){version=match[1];}else{version='10';}}if(name==='chrome'&&(match=ua.match(/\bopr\/([0-9\.]*)/))){if(match[1]){name='opera';version=match[1];}}if(layout==='trident'&&layoutversion>=7&&(match=ua.match(/\brv[ :\/]([0-9\.]*)/))){if(match[1]){name='msie';version=match[1];}}if(match=ua.match(/\bsilk\/([0-9.\-_]*)/)){if(match[1]){name='silk';version=match[1];}}versionNumber=parseFloat(version,10)||0.0;return profileCache[key]={name:name,layout:layout,layoutVersion:layoutversion,platform:platform,version:version,versionBase:(version!==x?Math.floor(versionNumber).toString():x),versionNumber:
versionNumber};},test:function(map,profile,exactMatchOnly){var conditions,dir,i,op,val,j,pieceVersion,pieceVal,compare;profile=$.isPlainObject(profile)?profile:$.client.profile();if(map.ltr&&map.rtl){dir=$('body').is('.rtl')?'rtl':'ltr';map=map[dir];}if(typeof map!=='object'||map[profile.name]===undefined){return!exactMatchOnly;}conditions=map[profile.name];if(conditions===false){return false;}if(conditions===null){return true;}for(i=0;i<conditions.length;i++){op=conditions[i][0];val=conditions[i][1];if(typeof val==='string'){pieceVersion=profile.version.toString().split('.');pieceVal=val.split('.');while(pieceVersion.length<pieceVal.length){pieceVersion.push('0');}while(pieceVal.length<pieceVersion.length){pieceVal.push('0');}compare=0;for(j=0;j<pieceVersion.length;j++){if(Number(pieceVersion[j])<Number(pieceVal[j])){compare=-1;break;}else if(Number(pieceVersion[j])>Number(pieceVal[j])){compare=1;break;}}if(!(eval(''+compare+op+'0'))){return false;}}else if(typeof val==='number'){if(!
(eval('profile.versionNumber'+op+val))){return false;}}}return true;}};}(jQuery));},{},{});mw.loader.implement("jquery.cookie",function($,jQuery){(function($){$.cookie=function(key,value,options){if(arguments.length>1&&(!/Object/.test(Object.prototype.toString.call(value))||value===null||value===undefined)){options=$.extend({},options);if(value===null||value===undefined){options.expires=-1;}if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days);}value=String(value);return(document.cookie=[encodeURIComponent(key),'=',options.raw?value:encodeURIComponent(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''));}options=value||{};var decode=options.raw?function(s){return s;}:decodeURIComponent;var pairs=document.cookie.split('; ');for(var i=0,pair;pair=pairs[i]&&pairs[i].split('=');i++){if(
decode(pair[0])===key)return decode(pair[1]||'');}return null;};})(jQuery);},{},{});mw.loader.implement("jquery.mwExtension",function($,jQuery){(function($){$.extend({trimLeft:function(str){return str===null?'':str.toString().replace(/^\s+/,'');},trimRight:function(str){return str===null?'':str.toString().replace(/\s+$/,'');},ucFirst:function(str){return str.charAt(0).toUpperCase()+str.substr(1);},escapeRE:function(str){return str.replace(/([\\{}()|.?*+\-\^$\[\]])/g,'\\$1');},isDomElement:function(el){return!!el&&!!el.nodeType;},isEmpty:function(v){var key;if(v===''||v===0||v==='0'||v===null||v===false||v===undefined){return true;}if(v.length===0){return true;}if(typeof v==='object'){for(key in v){return false;}return true;}return false;},compareArray:function(arrThis,arrAgainst){if(arrThis.length!==arrAgainst.length){return false;}for(var i=0;i<arrThis.length;i++){if($.isArray(arrThis[i])){if(!$.compareArray(arrThis[i],arrAgainst[i])){return false;}}else if(arrThis[i]!==arrAgainst[i])
{return false;}}return true;},compareObject:function(objectA,objectB){var prop,type;if(typeof objectA===typeof objectB){if(typeof objectA==='object'){if(objectA===objectB){return true;}else{for(prop in objectA){if(prop in objectB){type=typeof objectA[prop];if(type===typeof objectB[prop]){switch(type){case'object':if(!$.compareObject(objectA[prop],objectB[prop])){return false;}break;case'function':if(objectA[prop].toString()!==objectB[prop].toString()){return false;}break;default:if(objectA[prop]!==objectB[prop]){return false;}break;}}else{return false;}}else{return false;}}for(prop in objectB){if(!(prop in objectA)){return false;}}}}}else{return false;}return true;}});}(jQuery));},{},{});mw.loader.implement("jquery.throttle-debounce",function($,jQuery){(function(window,undefined){'$:nomunge';var $=window.jQuery||window.Cowboy||(window.Cowboy={}),jq_throttle;$.throttle=jq_throttle=function(delay,no_trailing,callback,debounce_mode){var timeout_id,last_exec=0;if(typeof no_trailing!==
'boolean'){debounce_mode=callback;callback=no_trailing;no_trailing=undefined;}function wrapper(){var that=this,elapsed=+new Date()-last_exec,args=arguments;function exec(){last_exec=+new Date();callback.apply(that,args);};function clear(){timeout_id=undefined;};if(debounce_mode&&!timeout_id){exec();}timeout_id&&clearTimeout(timeout_id);if(debounce_mode===undefined&&elapsed>delay){exec();}else if(no_trailing!==true){timeout_id=setTimeout(debounce_mode?clear:exec,debounce_mode===undefined?delay-elapsed:delay);}};if($.guid){wrapper.guid=callback.guid=callback.guid||$.guid++;}return wrapper;};$.debounce=function(delay,at_begin,callback){return callback===undefined?jq_throttle(delay,at_begin,false):jq_throttle(delay,callback,at_begin!==false);};})(this);},{},{});mw.loader.implement("mediawiki.legacy.ajax",function($,jQuery){(function(mw){function debug(text){if(!window.sajax_debug_mode){return false;}var e=document.getElementById('sajax_debug');if(!e){e=document.createElement('p');e.
className='sajax_debug';e.id='sajax_debug';var b=document.getElementsByTagName('body')[0];if(b.firstChild){b.insertBefore(e,b.firstChild);}else{b.appendChild(e);}}var m=document.createElement('div');m.appendChild(document.createTextNode(text));e.appendChild(m);return true;}function createXhr(){debug('sajax_init_object() called..');var a;try{a=new XMLHttpRequest();}catch(xhrE){try{a=new window.ActiveXObject('Msxml2.XMLHTTP');}catch(msXmlE){try{a=new window.ActiveXObject('Microsoft.XMLHTTP');}catch(msXhrE){a=null;}}}if(!a){debug('Could not create connection object.');}return a;}function doAjaxRequest(func_name,args,target){var i,x,uri,post_data;uri=mw.util.wikiScript()+'?action=ajax';if(window.sajax_request_type==='GET'){if(uri.indexOf('?')===-1){uri=uri+'?rs='+encodeURIComponent(func_name);}else{uri=uri+'&rs='+encodeURIComponent(func_name);}for(i=0;i<args.length;i++){uri=uri+'&rsargs[]='+encodeURIComponent(args[i]);}post_data=null;}else{post_data='rs='+encodeURIComponent(func_name);for(
i=0;i<args.length;i++){post_data=post_data+'&rsargs[]='+encodeURIComponent(args[i]);}}x=createXhr();if(!x){alert('AJAX not supported');return false;}try{x.open(window.sajax_request_type,uri,true);}catch(e){if(location.hostname==='localhost'){alert('Your browser blocks XMLHttpRequest to "localhost", try using a real hostname for development/testing.');}throw e;}if(window.sajax_request_type==='POST'){x.setRequestHeader('Method','POST '+uri+' HTTP/1.1');x.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}x.setRequestHeader('Pragma','cache=yes');x.setRequestHeader('Cache-Control','no-transform');x.onreadystatechange=function(){if(x.readyState!==4){return;}debug('received ('+x.status+' '+x.statusText+') '+x.responseText);if(typeof target==='function'){target(x);}else if(typeof target==='object'){if(target.tagName==='INPUT'){if(x.status===200){target.value=x.responseText;}}else{if(x.status===200){target.innerHTML=x.responseText;}else{target.innerHTML=
'<div class="error">Error: '+x.status+' '+x.statusText+' ('+x.responseText+')</div>';}}}else{alert('Bad target for sajax_do_call: not a function or object: '+target);}};debug(func_name+' uri = '+uri+' / post = '+post_data);x.send(post_data);debug(func_name+' waiting..');return true;}function wfSupportsAjax(){var request=createXhr(),supportsAjax=request?true:false;request=undefined;return supportsAjax;}var deprecationNotice='Sajax is deprecated, use jQuery.ajax or mediawiki.api instead.';mw.log.deprecate(window,'sajax_debug_mode',false,deprecationNotice);mw.log.deprecate(window,'sajax_request_type','GET',deprecationNotice);mw.log.deprecate(window,'sajax_debug',debug,deprecationNotice);mw.log.deprecate(window,'sajax_init_object',createXhr,deprecationNotice);mw.log.deprecate(window,'sajax_do_call',doAjaxRequest,deprecationNotice);mw.log.deprecate(window,'wfSupportsAjax',wfSupportsAjax,deprecationNotice);}(mediaWiki));},{},{});mw.loader.implement("mediawiki.legacy.wikibits",function($,
jQuery){(function(mw,$){var msg,win=window,ua=navigator.userAgent.toLowerCase(),isIE6=(/msie ([0-9]{1,}[\.0-9]{0,})/.exec(ua)&&parseFloat(RegExp.$1)<=6.0),isGecko=/gecko/.test(ua)&&!/khtml|spoofer|netscape\/7\.0/.test(ua),onloadFuncts=[];if(mw.config.get('wgBreakFrames')){if(win.top!==win.self){win.top.location=win.location;}}mw.log.deprecate(win,'redirectToFragment',function(fragment){var webKitVersion,match=navigator.userAgent.match(/AppleWebKit\/(\d+)/);if(match){webKitVersion=parseInt(match[1],10);if(webKitVersion<420){return;}}if(!win.location.hash){win.location.hash=fragment;if(isGecko){$(function(){if(win.location.hash===fragment){win.location.hash=fragment;}});}}},'Use the module mediawiki.action.view.redirectToFragment instead.');msg='Use feature detection or module jquery.client instead.';mw.log.deprecate(win,'clientPC',ua,msg);mw.log.deprecate(win,'is_gecko',false,msg);mw.log.deprecate(win,'is_chrome_mac',false,msg);mw.log.deprecate(win,'is_chrome',false,msg);mw.log.
deprecate(win,'webkit_version',false,msg);mw.log.deprecate(win,'is_safari_win',false,msg);mw.log.deprecate(win,'is_safari',false,msg);mw.log.deprecate(win,'webkit_match',false,msg);mw.log.deprecate(win,'is_ff2',false,msg);mw.log.deprecate(win,'ff2_bugs',false,msg);mw.log.deprecate(win,'is_ff2_win',false,msg);mw.log.deprecate(win,'is_ff2_x11',false,msg);mw.log.deprecate(win,'opera95_bugs',false,msg);mw.log.deprecate(win,'opera7_bugs',false,msg);mw.log.deprecate(win,'opera6_bugs',false,msg);mw.log.deprecate(win,'is_opera_95',false,msg);mw.log.deprecate(win,'is_opera_preseven',false,msg);mw.log.deprecate(win,'is_opera',false,msg);mw.log.deprecate(win,'ie6_bugs',false,msg);msg='Use jQuery instead.';mw.log.deprecate(win,'doneOnloadHook',undefined,msg);mw.log.deprecate(win,'onloadFuncts',[],msg);mw.log.deprecate(win,'runOnloadHook',$.noop,msg);mw.log.deprecate(win,'changeText',$.noop,msg);mw.log.deprecate(win,'killEvt',$.noop,msg);mw.log.deprecate(win,'addHandler',$.noop,msg);mw.log.
deprecate(win,'hookEvent',$.noop,msg);mw.log.deprecate(win,'addClickHandler',$.noop,msg);mw.log.deprecate(win,'removeHandler',$.noop,msg);mw.log.deprecate(win,'getElementsByClassName',function(){return[];},msg);mw.log.deprecate(win,'getInnerText',function(){return'';},msg);mw.log.deprecate(win,'addOnloadHook',function(hookFunct){if(onloadFuncts){onloadFuncts.push(hookFunct);}else{hookFunct();}},msg);$(win).on('load',function(){var i,functs;if(!onloadFuncts){return;}functs=onloadFuncts.slice();onloadFuncts=undefined;for(i=0;i<functs.length;i++){functs[i]();}});msg='Use jquery.checkboxShiftClick instead.';mw.log.deprecate(win,'checkboxes',[],msg);mw.log.deprecate(win,'lastCheckbox',null,msg);mw.log.deprecate(win,'setupCheckboxShiftClick',$.noop,msg);mw.log.deprecate(win,'addCheckboxClickHandlers',$.noop,msg);mw.log.deprecate(win,'checkboxClickHandler',$.noop,msg);mw.log.deprecate(win,'mwEditButtons',[],'Use mw.toolbar instead.');mw.log.deprecate(win,'mwCustomEditButtons',[],
'Use mw.toolbar instead.');mw.log.deprecate(win,'injectSpinner',$.noop,'Use jquery.spinner instead.');mw.log.deprecate(win,'removeSpinner',$.noop,'Use jquery.spinner instead.');mw.log.deprecate(win,'escapeQuotes',$.noop,'Use mw.html instead.');mw.log.deprecate(win,'escapeQuotesHTML',$.noop,'Use mw.html instead.');mw.log.deprecate(win,'jsMsg',mw.util.jsMessage,'Use mediawiki.notify instead.');msg='Use mediawiki.util instead.';mw.log.deprecate(win,'tooltipAccessKeyPrefix','alt-',msg);mw.log.deprecate(win,'tooltipAccessKeyRegexp',/\[(alt-)?(.)\]$/,msg);mw.log.deprecate(win,'updateTooltipAccessKeys',mw.util.updateTooltipAccessKeys,msg);mw.log.deprecate(win,'addPortletLink',mw.util.addPortletLink,msg);mw.log.deprecate(win,'appendCSS',mw.util.addCSS,msg);win.loadedScripts={};win.importScript=function(page){var uri=mw.config.get('wgScript')+'?title='+mw.util.wikiUrlencode(page)+'&action=raw&ctype=text/javascript';return win.importScriptURI(uri);};win.importScriptURI=function(url){if(win.
loadedScripts[url]){return null;}win.loadedScripts[url]=true;var s=document.createElement('script');s.setAttribute('src',url);s.setAttribute('type','text/javascript');document.getElementsByTagName('head')[0].appendChild(s);return s;};win.importStylesheet=function(page){var uri=mw.config.get('wgScript')+'?title='+mw.util.wikiUrlencode(page)+'&action=raw&ctype=text/css';return win.importStylesheetURI(uri);};win.importStylesheetURI=function(url,media){var l=document.createElement('link');l.rel='stylesheet';l.href=url;if(media){l.media=media;}document.getElementsByTagName('head')[0].appendChild(l);return l;};if(isIE6){win.importScriptURI(mw.config.get('stylepath')+'/common/IEFixes.js');}}(mediaWiki,jQuery));},{},{});mw.loader.implement("mediawiki.notify",function($,jQuery){(function(mw,$){'use strict';mw.notify=function(message,options){var d=$.Deferred();mw.loader.using('mediawiki.notification',function(){d.resolve(mw.notification.notify(message,options));},d.reject);return d.promise();};
}(mediaWiki,jQuery));},{},{});mw.loader.implement("mediawiki.toc",function($,jQuery){(function(mw,$){'use strict';mw.hook('wikipage.content').add(function($content){function toggleToc($toggleLink){var $tocList=$content.find('#toc ul:first');if($tocList.length){if($tocList.is(':hidden')){$tocList.slideDown('fast');$toggleLink.text(mw.msg('hidetoc'));$content.find('#toc').removeClass('tochidden');$.cookie('mw_hidetoc',null,{expires:30,path:'/'});}else{$tocList.slideUp('fast');$toggleLink.text(mw.msg('showtoc'));$content.find('#toc').addClass('tochidden');$.cookie('mw_hidetoc','1',{expires:30,path:'/'});}}}var $tocTitle,$tocToggleLink,hideTocCookie;$tocTitle=$content.find('#toctitle');$tocToggleLink=$content.find('#togglelink');if($content.find('#toc').length&&$tocTitle.length&&!$tocToggleLink.length){hideTocCookie=$.cookie('mw_hidetoc');$tocToggleLink=$('<a href="#" class="internal" id="togglelink"></a>').text(mw.msg('hidetoc')).click(function(e){e.preventDefault();toggleToc($(this));});
$tocTitle.append($tocToggleLink.wrap('<span class="toctoggle"></span>').parent().prepend('&nbsp;[').append(']&nbsp;'));if(hideTocCookie==='1'){toggleToc($tocToggleLink);}}});}(mediaWiki,jQuery));},{},{"hidetoc":"hide","showtoc":"show"});mw.loader.implement("mediawiki.util",function($,jQuery){(function(mw,$){'use strict';var util={init:function(){util.$content=(function(){var i,l,$content,selectors;selectors=['.mw-body-primary','.mw-body','#bodyContent','#mw_contentholder','#article','#content','#mw-content-text','body'];for(i=0,l=selectors.length;i<l;i++){$content=$(selectors[i]).first();if($content.length){return $content;}}return util.$content;})();},rawurlencode:function(str){str=String(str);return encodeURIComponent(str).replace(/!/g,'%21').replace(/'/g,'%27').replace(/\(/g,'%28').replace(/\)/g,'%29').replace(/\*/g,'%2A').replace(/~/g,'%7E');},wikiUrlencode:function(str){return util.rawurlencode(str).replace(/%20/g,'_').replace(/%3A/g,':').replace(/%2F/g,'/');},getUrl:function(str,
params){var url=mw.config.get('wgArticlePath').replace('$1',util.wikiUrlencode(typeof str==='string'?str:mw.config.get('wgPageName')));if(params&&!$.isEmptyObject(params)){url+=(url.indexOf('?')!==-1?'&':'?')+$.param(params);}return url;},wikiScript:function(str){str=str||'index';if(str==='index'){return mw.config.get('wgScript');}else if(str==='load'){return mw.config.get('wgLoadScript');}else{return mw.config.get('wgScriptPath')+'/'+str+mw.config.get('wgScriptExtension');}},addCSS:function(text){var s=mw.loader.addStyleTag(text);return s.sheet||s.styleSheet||s;},toggleToc:function($toggleLink,callback){var ret,$tocList=$('#toc ul:first');if(!$tocList.length){return null;}ret=$tocList.is(':hidden');$toggleLink.click();$tocList.promise().done(callback);return ret;},getParamValue:function(param,url){if(url===undefined){url=document.location.href;}var re=new RegExp('^[^#]*[&?]'+$.escapeRE(param)+'=([^&#]*)'),m=re.exec(url);if(m){return decodeURIComponent(m[1].replace(/\+/g,'%20'));}
return null;},tooltipAccessKeyPrefix:(function(){var profile=$.client.profile();if(profile.name==='opera'){return'shift-esc-';}if(profile.name==='chrome'){if(profile.platform==='mac'){return'ctrl-option-';}return'alt-shift-';}if(profile.platform!=='win'&&profile.name==='safari'&&profile.layoutVersion>526){return'ctrl-alt-';}if(profile.platform==='mac'&&profile.name==='firefox'&&profile.versionNumber>=14){return'ctrl-option-';}if(!(profile.platform==='win'&&profile.name==='safari')&&(profile.name==='safari'||profile.platform==='mac'||profile.name==='konqueror')){return'ctrl-';}if((profile.name==='firefox'||profile.name==='iceweasel')&&profile.versionBase>'1'){return'alt-shift-';}return'alt-';})(),tooltipAccessKeyRegexp:/\[(ctrl-)?(option-)?(alt-)?(shift-)?(esc-)?(.)\]$/,updateTooltipAccessKeys:function($nodes){if(!$nodes){if(document.querySelectorAll){$nodes=$(document.querySelectorAll('[accesskey]'));}else{$nodes=$(
'#column-one a, #mw-head a, #mw-panel a, #p-logo a, input, label, button');}}else if(!($nodes instanceof $)){$nodes=$($nodes);}$nodes.attr('title',function(i,val){if(val&&util.tooltipAccessKeyRegexp.test(val)){return val.replace(util.tooltipAccessKeyRegexp,'['+util.tooltipAccessKeyPrefix+'$6]');}return val;});},$content:null,addPortletLink:function(portlet,href,text,id,tooltip,accesskey,nextnode){var $item,$link,$portlet,$ul;if(arguments.length<3){return null;}$link=$('<a>').attr('href',href).text(text);if(tooltip){$link.attr('title',tooltip);}$portlet=$('#'+portlet);if($portlet.length===0){return null;}$ul=$portlet.find('ul').eq(0);if($ul.length===0){$ul=$('<ul>');if($portlet.find('div:first').length===0){$portlet.append($ul);}else{$portlet.find('div').eq(-1).append($ul);}}if($ul.length===0){return null;}$portlet.removeClass('emptyPortlet');if($portlet.hasClass('vectorTabs')){$item=$link.wrap('<li><span></span></li>').parent().parent();}else{$item=$link.wrap('<li></li>').parent();}if(
id){$item.attr('id',id);}if(tooltip){tooltip=$.trim(tooltip.replace(util.tooltipAccessKeyRegexp,''));if(accesskey){tooltip+=' ['+accesskey+']';}$link.attr('title',tooltip);if(accesskey){util.updateTooltipAccessKeys($link);}}if(accesskey){$link.attr('accesskey',accesskey);}if(nextnode){if(nextnode.nodeType||typeof nextnode==='string'){nextnode=$ul.find(nextnode);}else if(!nextnode.jquery||(nextnode.length&&nextnode[0].parentNode!==$ul[0])){$ul.append($item);return $item[0];}if(nextnode.length===1){nextnode.before($item);return $item[0];}}$ul.append($item);return $item[0];},jsMessage:function(message){if(!arguments.length||message===''||message===null){return true;}if(typeof message!=='object'){message=$.parseHTML(message);}mw.notify(message,{autoHide:true,tag:'legacy'});return true;},validateEmail:function(mailtxt){var rfc5322Atext,rfc1034LdhStr,html5EmailRegexp;if(mailtxt===''){return null;}rfc5322Atext='a-z0-9!#$%&\'*+\\-/=?^_`{|}~';rfc1034LdhStr='a-z0-9\\-';html5EmailRegexp=new RegExp
('^'+'['+rfc5322Atext+'\\.]+'+'@'+'['+rfc1034LdhStr+']+'+'(?:\\.['+rfc1034LdhStr+']+)*'+'$','i');return(null!==mailtxt.match(html5EmailRegexp));},isIPv4Address:function(address,allowBlock){if(typeof address!=='string'){return false;}var block=allowBlock?'(?:\\/(?:3[0-2]|[12]?\\d))?':'',RE_IP_BYTE='(?:25[0-5]|2[0-4][0-9]|1[0-9][0-9]|0?[0-9]?[0-9])',RE_IP_ADD='(?:'+RE_IP_BYTE+'\\.){3}'+RE_IP_BYTE;return address.search(new RegExp('^'+RE_IP_ADD+block+'$'))!==-1;},isIPv6Address:function(address,allowBlock){if(typeof address!=='string'){return false;}var block=allowBlock?'(?:\\/(?:12[0-8]|1[01][0-9]|[1-9]?\\d))?':'',RE_IPV6_ADD='(?:'+':(?::|(?::'+'[0-9A-Fa-f]{1,4}'+'){1,7})'+'|'+'[0-9A-Fa-f]{1,4}'+'(?::'+'[0-9A-Fa-f]{1,4}'+'){0,6}::'+'|'+'[0-9A-Fa-f]{1,4}'+'(?::'+'[0-9A-Fa-f]{1,4}'+'){7}'+')';if(address.search(new RegExp('^'+RE_IPV6_ADD+block+'$'))!==-1){return true;}RE_IPV6_ADD='[0-9A-Fa-f]{1,4}'+'(?:::?'+'[0-9A-Fa-f]{1,4}'+'){1,6}';return address.search(new RegExp('^'+RE_IPV6_ADD+block+'$'
))!==-1&&address.search(/::/)!==-1&&address.search(/::.*::/)===-1;}};mw.log.deprecate(util,'wikiGetlink',util.getUrl,'Use mw.util.getUrl instead.');mw.util=util;}(mediaWiki,jQuery));},{},{});mw.loader.implement("mediawiki.page.startup",function($,jQuery){(function(mw,$){mw.page={};$('html').addClass('client-js').removeClass('client-nojs');$(function(){mw.util.init();mw.hook('wikipage.content').fire($('#mw-content-text'));});}(mediaWiki,jQuery));},{},{});mw.loader.implement("skins.vector.js",function($,jQuery){(function($){var rtl=$('html').attr('dir')==='rtl';$.fn.collapsibleTabs=function(options){if(!this.length){return this;}var $settings=$.extend({},$.collapsibleTabs.defaults,options);this.each(function(){var $el=$(this);$.collapsibleTabs.instances=($.collapsibleTabs.instances.length===0?$el:$.collapsibleTabs.instances.add($el));$el.data('collapsibleTabsSettings',$settings);$el.children($settings.collapsible).each(function(){$.collapsibleTabs.addData($(this));});});if(!$.
collapsibleTabs.boundEvent){$(window).on('resize',$.debounce(500,function(){$.collapsibleTabs.handleResize();}));$.collapsibleTabs.boundEvent=true;}$.collapsibleTabs.handleResize();return this;};function calculateTabDistance(){var $leftTab,$rightTab,leftEnd,rightStart;if(!rtl){$leftTab=$('#left-navigation');$rightTab=$('#right-navigation');}else{$leftTab=$('#right-navigation');$rightTab=$('#left-navigation');}leftEnd=$leftTab.offset().left+$leftTab.width();rightStart=$rightTab.offset().left;return rightStart-leftEnd;}$.collapsibleTabs={instances:[],boundEvent:null,defaults:{expandedContainer:'#p-views ul',collapsedContainer:'#p-cactions ul',collapsible:'li.collapsible',shifting:false,expandCondition:function(eleWidth){return calculateTabDistance()>=(eleWidth+1);},collapseCondition:function(){return calculateTabDistance()<0;}},addData:function($collapsible){var $settings=$collapsible.parent().data('collapsibleTabsSettings');if($settings){$collapsible.data('collapsibleTabsSettings',{
expandedContainer:$settings.expandedContainer,collapsedContainer:$settings.collapsedContainer,expandedWidth:$collapsible.width(),prevElement:$collapsible.prev()});}},getSettings:function($collapsible){var $settings=$collapsible.data('collapsibleTabsSettings');if(!$settings){$.collapsibleTabs.addData($collapsible);$settings=$collapsible.data('collapsibleTabsSettings');}return $settings;},handleResize:function(){$.collapsibleTabs.instances.each(function(){var $el=$(this),data=$.collapsibleTabs.getSettings($el);if(data.shifting){return;}if($el.children(data.collapsible).length>0&&data.collapseCondition()){$el.trigger('beforeTabCollapse');$.collapsibleTabs.moveToCollapsed($el.children(data.collapsible+':last'));}if($(data.collapsedContainer+' '+data.collapsible).length>0&&data.expandCondition($.collapsibleTabs.getSettings($(data.collapsedContainer).children(data.collapsible+':first')).expandedWidth)){$el.trigger('beforeTabExpand');$.collapsibleTabs.moveToExpanded(data.collapsedContainer+
' '+data.collapsible+':first');}});},moveToCollapsed:function(ele){var outerData,expContainerSettings,target,$moving=$(ele);outerData=$.collapsibleTabs.getSettings($moving);if(!outerData){return;}expContainerSettings=$.collapsibleTabs.getSettings($(outerData.expandedContainer));if(!expContainerSettings){return;}expContainerSettings.shifting=true;target=outerData.collapsedContainer;$moving.css('position','relative').css((rtl?'left':'right'),0).animate({width:'1px'},'normal',function(){var data,expContainerSettings;$(this).hide();$('<span class="placeholder" style="display: none;"></span>').insertAfter(this);$(this).detach().prependTo(target).data('collapsibleTabsSettings',outerData);$(this).attr('style','display: list-item;');data=$.collapsibleTabs.getSettings($(ele));if(data){expContainerSettings=$.collapsibleTabs.getSettings($(data.expandedContainer));if(expContainerSettings){expContainerSettings.shifting=false;$.collapsibleTabs.handleResize();}}});},moveToExpanded:function(ele){var
data,expContainerSettings,$target,expandedWidth,$moving=$(ele);data=$.collapsibleTabs.getSettings($moving);if(!data){return;}expContainerSettings=$.collapsibleTabs.getSettings($(data.expandedContainer));if(!expContainerSettings){return;}expContainerSettings.shifting=true;$target=$(data.expandedContainer).find('span.placeholder:first');expandedWidth=data.expandedWidth;$moving.css('position','relative').css((rtl?'right':'left'),0).css('width','1px');$target.replaceWith($moving.detach().css('width','1px').data('collapsibleTabsSettings',data).animate({width:expandedWidth+'px'},'normal',function(){$(this).attr('style','display: block;');var data,expContainerSettings;data=$.collapsibleTabs.getSettings($(this));if(data){expContainerSettings=$.collapsibleTabs.getSettings($(data.expandedContainer));if(expContainerSettings){expContainerSettings.shifting=false;$.collapsibleTabs.handleResize();}}}));}};}(jQuery));jQuery(function($){$('div.vectorMenu').each(function(){var $el=$(this);$el.find(
'> h3 > a').parent().attr('tabindex','0').on('click keypress',function(e){if(e.type==='click'||e.which===13){$el.toggleClass('menuForceShow');e.preventDefault();}}).focus(function(){$el.find('> a').addClass('vectorMenuFocus');}).blur(function(){$el.find('> a').removeClass('vectorMenuFocus');}).find('> a:first').attr('tabindex','-1');});var $cactions=$('#p-cactions');$('#p-views ul').bind('beforeTabCollapse',function(){if($cactions.hasClass('emptyPortlet')){$cactions.removeClass('emptyPortlet').find('h3').css('width','1px').animate({'width':'24px'},390);}}).bind('beforeTabExpand',function(){if($cactions.find('li').length===1){$cactions.find('h3').animate({'width':'1px'},390,function(){$(this).attr('style','').parent().addClass('emptyPortlet');});}}).collapsibleTabs();});},{},{});
/* cache key: wiki:resourceloader:filter:minify-js:7:96a38d95fd187b74fcdb4c232b94213c */