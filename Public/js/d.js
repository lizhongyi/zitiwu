function loadaddr(id){
	  
	  if(!id) return false;
	  if($("#d-load").html()!="") return false;
	  
	  $.ajax({
		    url:"/Download/addr",
			data:{id:id},
			type:"POST",
			beforeSend: function(){
				 
				 $("#d-load").html('加载中.....');
				
				  },
				  success:function(data){
					  
					$("#d-load").html(data);
					 setTimeout(function(){
	
	   $("#down-box").css('margin-top','2em');
	
	},1000)

					}
		  
		  })
	  
	}


