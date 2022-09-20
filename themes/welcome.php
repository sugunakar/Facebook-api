<?php $this->load->view('includes/header');?>
<div class="container-fluid">
  <div class="col col-md-12">
    <div class="row">
    	<div class="col col-md-3"></div>
    	<div class="col col-md-6 text-center"><?php echo $fbUserId;?>,<?php echo $fbUserName;?><br /><br />
        
        <select id="fbPages">
        	<option value="0">Choose</option>
        	<?php if($fbpages){?>
				<?php foreach($fbpages as $pageData){?>
					<option value="<?php echo $pageData["id"];?>"><?php echo $pageData["name"];?></option>
				<?php }?>
			<?php }?>
        </select>
        
        <div class="table table-responsive pageInfotbl">
        	<table class="table table-border">
            	<tbody>
                	<tr>
                    	<th>Page Name</th>
                        <td><span class="pageName">N/A</span></td>
                    </tr>
                	<tr>
                    	<th>Followers Count</th>
                        <td><span class="followersCount">N/A</span></td>
                    </tr>
                	<tr>
                    	<th>Fans Count</th>
                        <td><span class="fanCount">N/A</span></td>
                    </tr>
                	<tr>
                    	<th>Rating Count</th>
                        <td><span class="ratingCount">N/A</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        </div>
    	<div class="col col-md-3"></div>
      	
        
        
        
        <a href="<?php echo $logoutUrl;?>">LOGOUT</a>
    </div>
  </div>
</div>
<?php $this->load->view('includes/footer');?>
<script type="text/javascript">
	$("#fbPages").change(function(){
		$getpageId = $(this).val();
		$(".pageInfotbl").hide();
		$.ajax({
			type: "POST",
			url: "/fbapi/getfbpageinfo/"+$getpageId,
			data: "",
			success: function(response){
				if(response.status=="success")
				{
					$('.pageName').html(response.pageName);
					$('.followersCount').html(response.followersCount);
					$('.fanCount').html(response.fanCount);
					$('.ratingCount').html(response.ratingCount);
					$(".pageInfotbl").show();
				}else{
					$(".pageInfotbl").hide();
					window.alert(response.message);
				}
			}
		});
	});
</script>