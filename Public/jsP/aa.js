	jQuery(document).ready(function () {
    //高亮当前选中的导航
    var myNav = $(".tab a"); 
    for (var i = 0; i < myNav.length; i++) {
        var links = myNav.eq(i).attr("href");
       
       var myURL = document.URL;
        var durl=/http:\/\/([^\/]+)\//i;
        domain = myURL.match(durl);
     
     var result = myURL.replace("http://"+domain[1],"");
      //    console.log(domain);  console.log(result);
          if (links == result) {
          	// myNav.eq(i).parents(".dropdown").addClass("open");
            myNav.eq(i).children("li").addClass("open");
        }
    }
    
    
    //高亮当前选中的顶部导航
    var myNav_0 = $(".Menu li a"); 
    for (var i_0 = 0; i_0 < myNav_0.length; i_0++) {
        var links_0 = myNav_0.eq(i_0).attr("href");
         console.log(links_0);
     var myURL_0 = document.URL;

        var durl_0=/http:\/\/([^\/]+)\//i;
        domain_0 = myURL_0.match(durl_0);
       
     	var result_0 = myURL_0.replace("http://"+domain_0[1],"");
      
        var split_1=result_0.split("/");  
        var split_2=links_0.split("/"); 
 //console.log(split_1);  console.log(split_2);console.log(111111111111);
       if (split_1[2] == split_2[2]) {
          	// myNav.eq(i).parents(".dropdown").addClass("open");
            myNav_0.eq(i_0).addClass("open");
       //     console.log(88888);
        }else{
       // 	 console.log(99999);
        }
    }
});