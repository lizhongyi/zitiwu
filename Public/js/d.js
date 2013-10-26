function loadaddr(id){
	  
	  if(!id) return false;
	 
	  
	  $.ajax({
		    url:"/Download/addr",
			data:{id:id},
			type:"POST",
			beforeSend: function(){
				 
				$(".d-bt a").text('下载中...');
				
				  },
				  success:function(data){
					  
					window.location=data;
					

					}
		  
		  })
	  
	}


