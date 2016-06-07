function () {
	
	
	$.ajax({
       url : 'login.php',
       type : 'POST', // Le type de la requête HTTP, ici devenu POST
       data : 'username=20100&passwd=' + $.md5('123txt'), // On fait passer nos variables, exactement comme en GET, au script more_com.php
       dataType : 'html'
    });
    
	
}
