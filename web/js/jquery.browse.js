/* 
 * Hack du depreciate de la fonction browser de jquery
 */

var matched,browser;jQuery.uaMatch=function(b){b=b.toLowerCase();var a=/(chrome)[ \/]([\w.]+)/.exec(b)||/(webkit)[ \/]([\w.]+)/.exec(b)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(b)||/(msie) ([\w.]+)/.exec(b)||b.indexOf("compatible")<0&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(b)||[];return{browser:a[1]||"",version:a[2]||"0"}};matched=jQuery.uaMatch(navigator.userAgent);browser={};if(matched.browser){browser[matched.browser]=true;browser.version=matched.version}if(browser.chrome){browser.webkit=true}else{if(browser.webkit){browser.safari=true}}jQuery.browser=browser;
