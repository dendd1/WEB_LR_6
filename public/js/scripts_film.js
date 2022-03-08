var accaunt_btn_1 = document.getElementById('commnet_btn');
var accaunt_btn_2 = document.getElementById('stop_btn');
var active_sect = 'comment';

var inline = "inline";

function change_info_active_btn(stat, nv_sect)
{
      document.getElementById(active_sect).style.display = "none";
      document.getElementById(nv_sect).style.display = stat;
      active_sect = nv_sect;
}



accaunt_btn_2.onclick = function(){ change_info_active_btn("flex", "comment");};
accaunt_btn_1.onclick = function(){ change_info_active_btn(inline, "comment_taker");};

