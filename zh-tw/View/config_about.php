<?php include('header.php'); ?>
<style>
#config_about_pre span {
	font-size:14px;
	margin-left:-17px;
}
#config_about_pre {
	font-family: Arial,宋体;
	line-height: 22px;
	width: 80%;
	background: #FFFFFF;
	padding: 20px 40px;
	border-radius: 7px;
	position: relative;
}
#dev_user {
	line-height:25px;
	position: absolute;
	top:20px;
	right:50px;
	background: #fff;
	font-family: Arial,宋体;
	color:#B9B9B9;
	white-space: normal;
	border: 1px solid #EEEEEE;
	border-radius: 7px;
	width:240px;
}
#dev_user p {
	margin:0px;
	height:26px;
}
p#dev_user_title {
	font-size:14px;
	color: #646370;
	margin-bottom:2px;
	background: #F8F8F8;
	padding: 5px 20px 3px;
}
#dev_user a{
	margin: 0px;
	margin-left:10px;
	float: left;
}
#dev_user span{
	font-size:12px;
	margin-right: 5px;
	font-size: 12px;
	float: right;
}
</style>

<div id="body">
<?php 
$c_name = 'config';
include('category_list.php'); 
?>

<pre id="config_about_pre">
<span>1) 關於我們</span>
AMH全名Amysql Host，是一款一直很努力、專注於LNMP平台應用開發的國產面板，
也是國內首個免費開源主機面板。面板基於(Linux / Nginx / MySQL / PHP) 構架環境運行。

<span>2) 學習與進步</span>
AMH使用GPL開源授權協議、所有源碼開放，目前已有較為豐富的使用說明、開發學習文檔，與有良好的用戶群，
您使用、學習AMH都是一沒錯的選擇，AMH希望用戶使用面板同時也有所學習與收穫、與您共同進步、發展。

<span>3) 使用與開發</span>
模塊擴展程序是AMH最大的特點，AMH主程序只做建站必要的功能，面板全部文件、程序500餘KB，結構清晰，輕巧高效。
面板其它相關輔助功能以模塊方式提供、按需擴展安裝，用戶也可應需求開發屬於自己的功能模塊。
模塊擴展程序也是做為AMH面板的重點，今後會提供更加豐富的功能模塊支持、
也希望有開發能力的用戶參與AMH模塊開發，為AMH的發展增添多一份力量、為用戶提供更多面板功能支持。

另外，AMH面板支持即時、定時、加密、本地、遠程、可選擇性、全方位面板數據備份功能，
為您提供數據無憂備份保護，也希望您能保持良好的數據定時備份習慣。

<span>4) 安全與用戶體驗</span>
做為服務器應用軟件，安全、穩定是優秀用戶體驗的基礎，AMH會盡最大能力考慮各方面安全問題，
面板WEB端是使用AMP MVC框架開發，統一數據請求入口安全驗證，與系統Shell入口統一安全過濾處理。
AMH支持用戶選擇安全模式/兼容模式的虛擬主機運行環境，安全防跨站、兼容環境，您可自由選擇切換。
同時，面板用戶體驗、操作交互方面AMH也會盡最大努力做好細節優化，與各瀏覽器兼容運行。

<span>5​​) 用戶與承諾</span>
AMH承諾不管是目前或是以後發布的版本，用戶都可永遠免費安裝使用，
面板所有功能不做任​​何限制，面板也不會植入任何第三方廣告、推介、等無關信息。
同時官方開發、發布的模塊擴展程序也都統一免費提供用戶下載使用。


您使用AMH如有任何問題、或需幫助、或是功能建議、
請您聯繫反饋於我們，AMH會時刻與您同在。
@ 2013年07月15日 AMH團隊
<a href="http://git.oschina.net/codebyme/Language-Project-AMH"><img src="http://git.oschina.net/codebyme/Language-Project-AMH/blob/master/Others/git.png" alt="LOGO"></a>
<div id="dev_user">
<p id="dev_user_title"><img src="View/images/dev.gif" /> 感謝參與AMH模塊開發用戶</p>
<p><a href="http://www.ixiqin.com" target="_blank">西秦公子</a> <span>已收據1个 2013-09-04</span></p>
<p><a href="http://www.baobaocool.com" target="_blank">BBShijie</a> <span>已收據2个 2013-08-27</span></p>
<p><a href="http://www.mf8.biz" target="_blank">ivmm</a> <span>已收據4个 2013-08-03</span></p>
<p><a href="http://www.lsanday.com" target="_blank">Zeraba</a> <span>已收录1个 2013-05-26</span></p>
</div>
</pre>

</div>
<?php include('footer.php'); ?>
