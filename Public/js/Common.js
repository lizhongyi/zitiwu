 function CheckValN(TID,TVal,TMes)
{if($(TID).value==TVal)
{$("S"+TID.substring(2,TID.length)).className='spanerror';$("S"+TID.substring(2,TID.length)).innerHTML=TMes;return false;}
else
return true;}
function $(KJID)
{return document.getElementById(KJID);}
function getEditorHTMLContents(TType,TFolderName,TMH)
{var str=window.showModalDialog("UpLoadImg.aspx?Type="+TType+"&FolderName="+TFolderName,"","resizable:no;scroll:no;status:no;dialogWidth=550px;dialogHeight=320px;center=yes;help=no");if(str==null)
return;var Editor=FCKeditorAPI.GetInstance(TMH);Editor.InsertHtml(str);}
function ImgButWZ(CZID,ImgButID,TT,LL,FTT,FLL)
{if(document.getElementById(CZID)==null)
return;if(document.getElementById(ImgButID)==null)
return;var pptt=fGetXY(document.getElementById(CZID));if(!isIE())
{document.getElementById(ImgButID).style.top=pptt.y+FTT+"px";document.getElementById(ImgButID).style.left=pptt.x+FLL+"px";}
else
{document.getElementById(ImgButID).style.top=pptt.y+TT+"px";document.getElementById(ImgButID).style.left=pptt.x+LL+"px";}}
function KJShow(KJID)
{if(document.getElementById(KJID)==null)
return;document.getElementById(KJID).style.display="";}
function KJHide(KJID)
{if(document.getElementById(KJID)==null)
return;document.getElementById(KJID).style.display="none";}
function KJinnerHTML(KJID,KJMes)
{if(document.getElementById(KJID)==null)
return;document.getElementById(KJID).innerHTML=KJMes;}
function NextKJ(KJID)
{if(event.keyCode==13)
{if(document.getElementById(KJID)==null)
return;event.keyCode=0;document.getElementById(KJID).focus();}}
function NextPostBut(KJID,KJTwo)
{if(event.keyCode==13)
{if(document.activeElement.type=="textarea")
return;if(document.getElementById(KJID)==null)
{if(document.getElementById(KJTwo)==null)
return;else
{if(document.getElementById(KJTwo).disabled==true)
return;document.getElementById(KJTwo).click();}}
else
{if(document.getElementById(KJID).disabled==true)
return;document.getElementById(KJID).click();}}}
function ButFinish(KJID,KJTwo)
{if(document.getElementById(KJID)==null)
return;document.getElementById(KJID).disabled=true;if(KJTwo=="")
return;if(document.getElementById(KJTwo)==null)
return;document.getElementById(KJTwo).disabled=true;}
function ReadFlv(url,w,h,win)
{var show="<object id='flvplayer'  classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0' width='"+w+"' height='"+h+"' align='middle'>"+"<param name='movie' value='"+url+"' />"+"<param name='wmode' value='"+win+"' />"+"<param name='allowScriptAccess' value='always' />"+"<param name='quality' value='high' />"+"<param name='swLiveConnect' value='true' />"+"<embed name='flvplayer' id='flvplayer' allowScriptAccess='always' src='"+url+"' wmode='"+win+"' menu='false' quality='high' width='"+w+"' height='"+h+"' align='middle' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' swLiveConnect='true' />"+"</object>";document.write(show);}
function FSelOnChange(FS)
{if(FS==null)
return;if(document.getElementById("trClassStyle")==null)
return;if(FS.value=="0")
document.getElementById("trClassStyle").style.display="";else
document.getElementById("trClassStyle").style.display="none";}
function CouSeconds(EndT,BeginT)
{var TEndT=EndT.split(":");var End=parseInt(TEndT[0])*3600+parseInt(TEndT[1])*60+parseInt(TEndT[2]);var TBeginT=BeginT.split(":");var Begin=parseInt(TBeginT[0])*3600+parseInt(TBeginT[1])*60+parseInt(TBeginT[2]);return parseInt(End)-parseInt(Begin);}
function CheckSearch()
{if(!CheckVal(document.getElementById("TBSearchName"),"","请输入搜索标题！",true))
return false;if(!CheckVal(document.getElementById("TBSearchName"),"请输入标题","请输入搜索标题！",true))
return false;ThePosting("SelMoveFClass|SelMoveClass","ImgUpdating","TPostTitle","数据搜索","TPostMes","数据搜索，请耐心等待... MyBR@#这可能需要几秒:)",200,150);return true;}
function CheckFolderMes()
{if(document.getElementById("TBFolderName").value==NowFolderName)
return;NowFolderName=document.getElementById("TBFolderName").value;if(document.getElementById("TBFolderName").value=="")
{document.getElementById("spanFolderMes").innerText="请输入文件名";return;}
var myRequest=new ajaxRequest();var myguid=GetNowTime();var FolderName=URLEncode(document.getElementById("TBFolderName").value);myRequest.url="../JSCPU.aspx?Type=GetFolderFile&FolderName="+FolderName+"&GUID="+myguid;document.getElementById("spanFolderMes").innerText="正在读取文件夹信息......";myRequest.callback=function GetFirstMes(GetMes)
{if(GetMes.responseText!="")
{document.getElementById("spanFolderMes").innerText="该文件夹有文件："+GetMes.responseText;}};myRequest.send();}
function SetUpingFTP()
{if(!CheckVal(document.getElementById("TBFTPID"),"","FTP用户名不能为空！",true))
return false;if(!CheckVal(document.getElementById("TBFTPPassWord"),"","FTP密码不能为空！",true))
return false;var myRequest=new ajaxRequest();var myguid=GetNowTime();var FTPID=URLEncode(document.getElementById("TBFTPID").value);var FTPPW=URLEncode(document.getElementById("TBFTPPassWord").value);myRequest.url="../JSCPU.aspx?Type=UpDateFTP&FTPID="+FTPID+"&FTPPW="+FTPPW+"&GUID="+myguid;document.getElementById("ButPostFTP").value="更新数据中";document.getElementById("ButPostFTP").disabled=true;document.getElementById("ButCloseFTP").disabled=true;myRequest.callback=function GetFirstMes(GetMes)
{if(GetMes.responseText!="")
{document.getElementById("ButPostFTP").value="设置完成";document.getElementById("ButPostFTP").disabled=false;document.getElementById("ButCloseFTP").disabled=false;document.getElementById('SetUpFTP').style.display="none";}};myRequest.send();}
function CheckFTP()
{if(document.getElementById("AFTPUpLoad").href==window.location.href+"#")
{alert("请先设置FTP帐号信息！");document.getElementById("ASetUpFTP").click();return false}
return true;}
function resizeLocalPic()
{var loadedImgObj=this;var img=new Image();img.src=loadedImgObj.src;var HBL=parseInt(img.width)/TheImgWidth;var WBL=parseInt(img.height)/TheImgHeight;if(HBL<1&&WBL<1)
return;else
{var W,H;if(HBL>=WBL)
{W=parseInt(img.width/HBL)+"px";H=parseInt(img.height/HBL)+"px";loadedImgObj.style.width=W;loadedImgObj.style.height=H;}
else
{W=parseInt(img.width/WBL)+"px";H=parseInt(img.height/WBL)+"px";loadedImgObj.style.width=W;loadedImgObj.style.height=H;}}}
function showLocalpic(preview,file,nofile)
{if(document.all)
{var prev=document.getElementById(preview);var f=document.getElementById(file);if(f.value!=null&&f.value!="")
{prev.src=f.value;prev.onload=resizeLocalPic;}
else
{prev.src=nofile;prev.style.width=TheImgWidth+"px";prev.style.height=TheImgHeight+"px";}}}
function resizeLocalPicWater()
{var loadedImgObj=this;var img=new Image();img.src=loadedImgObj.src;var HBL=parseInt(img.width)/TheImgWaterWidth;var WBL=parseInt(img.height)/TheImgWaterHeight;if(HBL<1&&WBL<1)
return;else
{var W,H;if(HBL>=WBL)
{W=parseInt(img.width/HBL)+"px";H=parseInt(img.height/HBL)+"px";loadedImgObj.style.width=W;loadedImgObj.style.height=H;}
else
{W=parseInt(img.width/WBL)+"px";H=parseInt(img.height/WBL)+"px";loadedImgObj.style.width=W;loadedImgObj.style.height=H;}}}
function showLocalpicWater(preview,file,nofile)
{if(document.all)
{var prev=document.getElementById(preview);var f=document.getElementById(file);if(f.value!=null&&f.value!="")
{prev.src=f.value;prev.onload=resizeLocalPicWater;}
else
{prev.src=nofile;prev.style.width=TheImgWaterWidth+"px";prev.style.height=TheImgWaterHeight+"px";}}}
function ThePosting(HideKJ,ShowID,ShowTitleID,ShowTitle,ShowMesID,ShowMes,TTop,TLeft)
{ShowTheFullDiv(HideKJ);var windowWidth=document.body.clientWidth|document.documentElement.clientWidth;var windowHeight=document.documentElement.clientHeight;var windowTop=document.documentElement.scrollTop;document.getElementById(ShowID).style.top=windowTop+(windowHeight/2)-TTop+"px";document.getElementById(ShowID).style.left=windowWidth/2-TLeft+"px";document.getElementById(ShowID).style.display="block";if(document.getElementById(ShowTitleID)!=null)
{if(ShowTitle!="")
document.getElementById(ShowMesID).innerHTML=ShowTitle;}
if(document.getElementById(ShowMesID)!=null)
{if(ShowMes!="")
document.getElementById(ShowMesID).innerHTML=TheBrRel(ShowMes);}
setInterval("LoadDivImgWZ('"+ShowID+"','"+TTop+"')",50);}
function LoadDivImgWZ(TMDiv,TTop)
{var windowHeight=document.documentElement.clientHeight;var windowTop=document.documentElement.scrollTop;var TempTop=windowTop+(windowHeight/2)-TTop;var DivTop=document.getElementById(TMDiv).style.top;var Cou=0;if(DivTop=="")
DivTop=10;else
DivTop=parseInt(DivTop);if(TempTop==DivTop)return;if(TempTop>DivTop)
{Cou=parseInt(((TempTop-DivTop)/5));if(Cou<1)
document.getElementById(TMDiv).style.top=DivTop+0.1+"px";else
document.getElementById(TMDiv).style.top=DivTop+Cou+"px";}
else
{Cou=parseInt(((DivTop-TempTop)/5));if(Cou<1)
document.getElementById(TMDiv).style.top=DivTop-0.1+"px";else
document.getElementById(TMDiv).style.top=DivTop-Cou+"px";}}
function TheBrRel(BrMes)
{BrMes=BrMes.replace(/\MyBR@#/g,"<br />");return BrMes;}
function ShowImgUpdatFinish(TKJ,TTop,TLeft)
{var windowWidth=document.body.clientWidth|document.documentElement.clientWidth;var windowHeight=document.documentElement.clientHeight;var windowTop=document.documentElement.scrollTop;document.getElementById("ImgUpdatFinish").style.top=windowTop+windowHeight/2-TTop+"px";document.getElementById("ImgUpdatFinish").style.left=windowWidth/2-TLeft+"px";document.getElementById("ImgUpdatFinish").style.display="block";ShowTheFullDiv(TKJ);setTimeout("HideImgUpdatFinish('"+TKJ+"')",1000);}
function HideImgUpdatFinish(TKJ)
{if(document.getElementById("AutoCloseTime").innerHTML=="5秒后自动关闭.")
{document.getElementById("AutoCloseTime").innerHTML="4秒后自动关闭."
setTimeout("HideImgUpdatFinish('"+TKJ+"')",1000);return;}
if(document.getElementById("AutoCloseTime").innerHTML=="4秒后自动关闭.")
{document.getElementById("AutoCloseTime").innerHTML="3秒后自动关闭."
setTimeout("HideImgUpdatFinish('"+TKJ+"')",1000);return;}
if(document.getElementById("AutoCloseTime").innerHTML=="3秒后自动关闭.")
{document.getElementById("AutoCloseTime").innerHTML="2秒后自动关闭."
setTimeout("HideImgUpdatFinish('"+TKJ+"')",1000);return;}
if(document.getElementById("AutoCloseTime").innerHTML=="2秒后自动关闭.")
{document.getElementById("AutoCloseTime").innerHTML="1秒后自动关闭."
setTimeout("HideImgUpdatFinish('"+TKJ+"')",1000);return;}
HideTheFullDiv(TKJ);document.getElementById("ImgUpdatFinish").style.display="none";}
function CheckMoveImg()
{if(document.getElementById("SelMoveClass")!=null)
{if(!CheckVal(document.getElementById("SelMoveClass"),"","请选择你将移动到的类别！",true))
return false;if(!CheckVal(document.getElementById("SelMoveClass"),"0","请选择你将移动到的类别！",true))
return false;document.getElementById("HMoveClassID").value=document.getElementById("SelMoveClass").value;}
else
{if(!CheckVal(document.getElementById("SelMoveFClass"),"","请选择你将移动到的类别！",true))
return false;if(!CheckVal(document.getElementById("SelMoveFClass"),"0","请选择你将移动到的类别！",true))
return false;document.getElementById("HMoveClassID").value=document.getElementById("SelMoveFClass").value;}
return true;}
function GetNowTime()
{var now=new Date();var yy=now.getFullYear();var mm=now.getMonth();var day=now.getDay();var hour=now.getHours();var min=now.getMinutes();var sec=now.getSeconds();var ms=now.getMilliseconds();return yy+"-"+mm+"-"+day+"-"+hour+"-"+min+"-"+sec+"-"+ms;}
function ShowTheFullDiv(SelMes)
{var windowHeight=document.documentElement.clientHeight;if(parseInt(windowHeight)<parseInt(document.body.clientHeight))
windowHeight=document.body.clientHeight;var windowWidth=document.body.clientWidth|document.documentElement.clientWidth;document.getElementById("FullDiv").style.height=windowHeight+"px";document.getElementById("FullDiv").style.width=windowWidth-2+"px";document.getElementById("FullDiv").style.left=0+"px";document.getElementById("FullDiv").style.top=0+"px";document.getElementById("FullDiv").style.display="block";var TSelMes=SelMes.split("|");for(i=0;i<TSelMes.length;i++)
{if(document.getElementById(TSelMes[i])!=null)
document.getElementById(TSelMes[i]).style.visibility="hidden";}}
function HideTheFullDiv(SelMes)
{document.getElementById("FullDiv").style.display="none";var TSelMes=SelMes.split("|");for(i=0;i<TSelMes.length;i++)
{if(document.getElementById(TSelMes[i])!=null)
document.getElementById(TSelMes[i]).style.visibility="visible";}}
function ShowTheFloatingDiv(FloatingDivID,WZ,Top,Left)
{if(document.getElementById(FloatingDivID)==null)
return;var pptt=fGetXY(WZ);document.getElementById(FloatingDivID).style.top=pptt.y+Top+"px";document.getElementById(FloatingDivID).style.left=pptt.x+Left+"px";document.getElementById(FloatingDivID).style.display="block";}
function Confirm(Mes)
{if(confirm(Mes))return true;return false;}
function RCheckBoxCheck(RName,CBName,Cou,TF)
{for(i=0;i<Cou;i++)
{if(document.getElementById(RName+"__ctl"+i+"_"+CBName)!=null)
{document.getElementById(RName+"__ctl"+i+"_"+CBName).checked=TF;}}}
function ButClickCheckCB(RName,CBName,Cou,CBMes,confirmMes)
{var CBHaveCheck=false;for(i=0;i<Cou;i++)
{if(document.getElementById(RName+"__ctl"+i+"_"+CBName)!=null)
{if(document.getElementById(RName+"__ctl"+i+"_"+CBName).checked)
{CBHaveCheck=true;break;}}}
if(!CBHaveCheck)
{alert(CBMes);return false;}
if(confirmMes!="")
{if(!confirm(confirmMes))
return false;}
return true;}
function Point(iX,iY)
{this.x=iX;this.y=iY;}
function fGetXY(aTag)
{if(aTag==null)
return;var oTmp=aTag;var pt=new Point(0,0);do
{pt.x+=oTmp.offsetLeft;pt.y+=oTmp.offsetTop;oTmp=oTmp.offsetParent;}
while(oTmp.tagName!="BODY");return pt;}
function ShowTips(TigsMes,TigsID,WZ,LOrR)
{if(document.getElementById(TigsID)!=null)
{var pptt=fGetXY(WZ);document.getElementById(TigsID).style.top=pptt.y+12+"px";document.getElementById(TigsID).style.left=pptt.x+12+"px";var windowHeight=document.body.clientHeight|document.documentElement.clientHeight;var windowWidth=document.body.clientWidth|document.documentElement.clientWidth;if(document.getElementById(TigsID).style.top<0)
document.getElementById(TigsID).style.top="0px";if(parseInt(document.getElementById(TigsID).style.top)+200>windowHeight)
{document.getElementById(TigsID).style.top=pptt.y-50+"px";}
if(document.getElementById(TigsID).style.left<0)
document.getElementById(TigsID).style.left="0px";if(parseInt(document.getElementById(TigsID).style.left)+255>windowWidth)
document.getElementById(TigsID).style.left=parseInt(document.getElementById(TigsID).style.left)-255+"px";document.getElementById(TigsID).innerHTML=TheBrRel(TigsMes);document.getElementById(TigsID).style.display="inline-block";}}
function HideTips(TigsID)
{if(document.getElementById(TigsID)!=null)
document.getElementById(TigsID).style.display="none";}
function CheckTxtOrder(KJID)
{if(document.getElementById(KJID)!=null)
{if(document.getElementById(KJID).value.trim()=="")
document.getElementById(KJID).value="0";else
{document.getElementById(KJID).value=document.getElementById(KJID).value.replace(/[^\d]/g,'')
var TOrderMes=document.getElementById(KJID).value;var OrderMes="";for(i=0;i<TOrderMes.length-1;i++)
{if(TOrderMes.substring(i,i+1)!="0")
{document.getElementById(KJID).value=TOrderMes.substring(i,TOrderMes.length);if(document.getElementById(KJID).value.length>9)
document.getElementById(KJID).value="999999999"
return;}}
document.getElementById(KJID).value=TOrderMes.substring(TOrderMes.length-1,TOrderMes.length);}}}
function AddFavorite(sURL,sTitle)
{try
{window.external.addFavorite(sURL,sTitle);}
catch(e)
{try
{window.sidebar.addPanel(sTitle,sURL,"");}
catch(e)
{alert("加入收藏失败，请使用Ctrl+D进行添加");}}}
function SetHome(obj,vrl)
{try
{obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);}
catch(e)
{if(window.netscape)
{try
{netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");}
catch(e)
{alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将[signed.applets.codebase_principal_support]设置为'true'");}
var prefs=Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);prefs.setCharPref('browser.startup.homepage',vrl);}}}
function CheckVal(TObj,Mes,alMes,IsSet)
{if(TObj==null)
return true;if(TObj.value==Mes)
{try
{if(IsSet)
TObj.focus();}
catch(e)
{if(TObj.style.display!="none")
return true;}
if(alMes!="")
alert(alMes);return false;}
return true;}
function CheckValRex(TObj,Mes,alMes,IsSet)
{if(TObj==null)
return true;var filter=Mes;if(!filter.test(TObj.value))
{if(alMes!="")
alert(alMes);try
{if(IsSet)
TObj.focus();}catch(e){return true;}
return false;}
return true;}
function CheckValUpLoad(TObj,Mes,alMes)
{if(TObj==null)
return true;if(TObj.value!="")
{var PicMes=TObj.value.toLowerCase();var TempVal=Mes.toLowerCase().split(",");for(i=0;i<TempVal.length;i++)
{if(PicMes.indexOf(TempVal[i])>=0)
return true;}
if(alMes!="")
alert(alMes);return false;}
else
return true;}
function CheckValUpLoadF(TObj,Mes,alMes)
{if(TObj==null)
return true;if(TObj.value!="")
{var PicMes=TObj.value.toLowerCase();var TempVal=Mes.toLowerCase().split(",");for(i=0;i<TempVal.length;i++)
{if(PicMes.indexOf(TempVal[i])>=0)
{alert(alMes);return false;}}
return true;}
else
return true;}
function PicChange(TObj,TObjBut,TempPic,Value,TWidth,THeight)
{if(TempPic.length<=0)
{TempPic=TObj.src;TObjBut.disabled=null;}
if(Value.length>0)
{TObj.src=Value;}
TObj.width=TWidth;TObj.height=THeight;}
function ResetPic(TObj,TObjUpLoad,TempPic,PicSrc)
{TObjUpLoad.select();document.execCommand('Delete');if(TempPic.length>0)
TObj.src=TempPic;else
TObj.src=PicSrc;}
function CheckKey()
{return((event.keyCode>=48)&&(event.keyCode<=57));}
function URLEncode(strInput)
{strTmp=encodeURI(strInput);strTmp=strTmp.replace(/\ /g,'+');strTmp=strTmp.replace(/\@/g,'%40');strTmp=strTmp.replace(/\#/g,'%23');strTmp=strTmp.replace(/\$/g,'%24');strTmp=strTmp.replace(/\&/g,'%26');strTmp=strTmp.replace(/\+/g,'%2B');strTmp=strTmp.replace(/\=/g,'%3D');strTmp=strTmp.replace(/\;/g,'%3B');strTmp=strTmp.replace(/\:/g,'%3A');strTmp=strTmp.replace(/\//g,'%2F');strTmp=strTmp.replace(/\?/g,'%3F');strTmp=strTmp.replace(/\,/g,'%2C');return strTmp;}
function setCaret(textObj)
{if(textObj.createTextRange)
{textObj.caretPos=document.selection.createRange().duplicate();}}
function insertAtCaret(textObj,textFeildValue)
{if(document.all)
{if(textObj.createTextRange&&textObj.caretPos)
{var caretPos=textObj.caretPos;caretPos.text=caretPos.text.charAt(caretPos.text.length-1)==' '?textFeildValue+' ':textFeildValue;}
else
{textObj.value=textFeildValue;}}
else
{if(textObj.setSelectionRange)
{var rangeStart=textObj.selectionStart;var rangeEnd=textObj.selectionEnd;var tempStr1=textObj.value.substring(0,rangeStart);var tempStr2=textObj.value.substring(rangeEnd);textObj.value=tempStr1+textFeildValue+tempStr2;}
else
{alert("This   version   of   Mozilla   based   browser   does   not   support   setSelectionRange");}}}
function $(id){return document.getElementById(id);}
function AttachEvent(){var obj=arguments[0];if(isIE()){if(obj==null){window.attachEvent(arguments[1],arguments[2]);}
else{obj.attachEvent(arguments[1],arguments[2]);}}
else{if(obj==null){window.addEventListener(arguments[1].substring(2),arguments[2],arguments[3]);}
else{obj.addEventListener(arguments[1].substring(2),arguments[2],arguments[3]);}}}
String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");}
String.prototype.half=function(){var i;var result='';for(i=0;i<this.length;i++){code=this.charCodeAt(i);if(code>=65281&&code<65373){result+=String.fromCharCode(this.charCodeAt(i)-65248);}
else{result+=this.charAt(i);}}
return result;}
function isIE(){if(navigator.appName.indexOf("Explorer")>-1){return true;}
else{return false;}}
function ajaxRequest(){var xmlObj=false;var CBfunc,ObjSelf;ObjSelf=this;try{xmlObj=new XMLHttpRequest;}
catch(e){try{xmlObj=new ActiveXObject("MSXML2.XMLHTTP");}
catch(e2){try{xmlObj=new ActiveXObject("Microsoft.XMLHTTP");}
catch(e3){xmlObj=false;}}}
if(!xmlObj)return false;this.method="GET";this.url;this.async="true";this.content="";this.callback=function(cbobj){return;}
this.send=function(){if(!this.method||!this.url)return false;xmlObj.open(this.method,this.url,this.async);if(this.method=="POST")xmlObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");xmlObj.onreadystatechange=function(){if(xmlObj.readyState==4){if(xmlObj.status==200){ObjSelf.callback(xmlObj);}}}
if(this.method=="POST")xmlObj.send(this.content);else xmlObj.send(null);}}
Array.prototype.insertAt=function(index,value){var begin=this.slice(0,index);var end=this.slice(index);begin.push(value);return begin.concat(end);}
Array.prototype.removeAt=function(index){var begin=this.slice(0,index);var end=this.slice(index);begin.pop();return begin.concat(end);}
function setCookie(name,value,expr)
{try{var argv=setCookie.arguments;var argc=setCookie.arguments.length;var expires=(argc>2)?argv[2]:null;if(expires!=null)
{var LargeExpDate=new Date();LargeExpDate.setTime(LargeExpDate.getTime()+(expires*1000*3600*24));}
document.cookie=name+"="+escape(value)+((expires==null)?"":("; expires="+LargeExpDate.toGMTString()));return true;}
catch(e){return false;}}
function getCookie(Name)
{var search=Name+"="
if(document.cookie.length>0)
{offset=document.cookie.indexOf(search)
if(offset!=-1)
{offset+=search.length
end=document.cookie.indexOf(";",offset)
if(end==-1)end=document.cookie.length
{return unescape(document.cookie.substring(offset,end))}}
else
{return;}}}
function getXMLR()
{var xmlhttp,alerted;try
{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP")}
catch(e)
{try
{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")}
catch(E)
{alert("请安装Microsofts XML parsers")}}
if(!xmlhttp&&!alerted)
{try
{xmlhttp=new XMLHttpRequest();}
catch(e)
{alert("你的浏览器不支持XMLHttpRequest对象，请升级");}}
return xmlhttp;}
function ShowD(eve,tid)
{$(tid).style.left=eve.clientX+2+"px";$(tid).style.top=eve.clientY+GetScrollTop()+2+"px";$(tid).releaseCapture();$(tid).style.display="block";}
var w3c=(document.getElementById)?true:false;var agt=navigator.userAgent.toLowerCase();var ie=((agt.indexOf("msie")!=-1)&&(agt.indexOf("opera")==-1)&&(agt.indexOf("omniweb")==-1));function IeTrueBody(){return(document.compatMode&&document.compatMode!="BackCompat")?document.documentElement:document.body;}
function GetScrollTop(){return ie?IeTrueBody().scrollTop:window.pageYOffset;}
function DigitInput(el,ev) {
//8：退格键、46：delete、37-40： 方向键
//48-57：小键盘区的数字、96-105：主键盘区的数字
//110、190：小键盘区和主键盘区的小数
//189、109：小键盘区和主键盘区的负号

    var event = ev || window.event;                             //IE、FF下获取事件对象
    var currentKey = event.charCode||event.keyCode;             //IE、FF下获取键盘码
    

        if (currentKey!=8 && (currentKey<37 || currentKey>40) && (currentKey<48 || currentKey>57) )
            if (window.event)                       
                event.returnValue=false;                 
            else                                    
                event.preventDefault();
	else {return currentKey ;}

}

function IE6Cache()
		{
			var  m = document.uniqueID /**//*IE*/
			&& document.compatMode  /**//*>=IE6*/
			&& !window.XMLHttpRequest /**//*<=IE6*/
			&& document.execCommand;    
			try
			{
				if(!!m)
					m("BackgroundImageCache", false, true) /**//* = IE6 only */        
			}
			catch(oh){};
		}

function LoadMes(type,kj)
		{
			var myRequest = new ajaxRequest();
			var myguid = GetNowTime();
			myRequest.url = "Read.aspx?Type="+type+"&GUID="+myguid;
			document.getElementById(kj).innerHTML = "<table width=100%><tr><td align=center><img src=\"img/loading.gif\"></td></tr></table>";
			myRequest.callback = function GetFirstMes(GetMes)
								{
									if (GetMes.responseText=="Lost")
										document.getElementById(kj).innerHTML = "数据读取失败";
									else
										document.getElementById(kj).innerHTML = GetMes.responseText;
								};
			myRequest.send();
		}
function ImgButWZ(CZID,ImgButID,TT,LL,FTT,FLL)
{if(document.getElementById(CZID)==null)
return;if(document.getElementById(ImgButID)==null)
return;var pptt=fGetXY(document.getElementById(CZID));if(!isIE())
{document.getElementById(ImgButID).style.top=pptt.y+FTT+"px";document.getElementById(ImgButID).style.left=pptt.x+FLL+"px";}
else
{document.getElementById(ImgButID).style.top=pptt.y+TT+"px";document.getElementById(ImgButID).style.left=pptt.x+LL+"px";}}