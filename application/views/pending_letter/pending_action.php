<style>
.starbtn,.starrr_disable { color: #ea0421; font-size: 16px;}
</style>
<div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
         <div class="panel-heading"><svg class="glyph stroked email"></svg>Sent Papers</div>
          <div class="panel-body">
            <div class="canvas-wrapper">
                    <div class="table-responsive">          
                        <table class="table">
                          <thead>
                            <tr>
                              
                              <th>MEMO NO.</th>
                              <th>SENT TO</th>
                              <th>ISSUING AUTHORITY</th>
                              <th>SUBJECT</th>
                              <th>DATE OF SENDING</th>
                              <th>ACTION DETAILS</th>
                              <th>ACTION STATUS</th>
                              <th>DEADLINE OF ACTION</th>
                              <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-ok" ></i></th>
                            </tr>
                          </thead>
                          
                           <tbody>
                            <?php foreach($results as $value){?>
                            <tr id="<?php echo 'c2'.$value['action_id'] ;?>">
                              <td><a style="color:green;" href="<?php echo base_url().'pdf_resource/files/'.$value['letter_name'];?>" target="_blank"><?php echo $value["memo_no"];?></a>
                              
                              <?php if($value["star_mark"] > 0 && $value["star_given_by"] > 0 && $currentUserRank < $starGivenUserRank){ ?>
									<div class="starrr starrr_disable" data-rating='<?php echo $value["star_mark"]; ?>' title="Rating given by <?php  echo $value["ratingGivenUser"];?>"></div>
								  <?php } elseif($value["star_mark"] > 0 && $value["star_given_by"] > 0 && $currentUserRank >= $starGivenUserRank) { ?> 
								  <div class="starrr starbtn" data-id="<?php echo $value["letter_id"];?>" data-rating='<?php echo $value["star_mark"]; ?>'></div>
								  <?php } else { ?> 
								  <div class="starrr starbtn" data-id="<?php echo $value["letter_id"];?>"></div>
								<?php } ?>
								
                              </td>
                              <td>
							  <?php if($value["action_receiver"] !=0 ) echo fetch_user_name($value["action_receiver"]);
							   else if($value["recv_id"] !=0) echo fetch_user_name($value["recv_id"]);
							  
							  ?></td>
                              <td><?php echo $value["authority_name"];?></td>
                              <td><?php echo $value["subject"];?></td>
                              <td><?php if($value["date_of_action"]!="0000-00-00 00:00:00")echo date("d-m-Y",strtotime($value["date_of_action"]));?></td>
                              <td><?php echo $value["action_details"];?></td>


                              <td>
							  <label class="status" id="">
							  <?php 
							  

								$today=date('Y-m-d');
						    	$now = strtotime($today); // or your date as well
								$your_date = strtotime($value['deadline_dt']);
								$datediff = $now - $your_date;
								$show= floor($datediff / (60 * 60 * 24));//exit;




							  if($value['action_status']=='P' && $show=='0'){echo'<label style="color:orange">Pending</label>'; 
							  if($value["action_remark"]!="") echo("(".$value["action_remark"].")");}
							  else
							if($value['action_status']=='P' && $show>'0'){echo'<label style="color:red">Pending</label>'; 
							  if($value["action_remark"]!="") echo("(".$value["action_remark"].")");}
							  else
								  if($value['action_status']=='P' && $show<'0'){echo'<label style="color:blue">Pending</label>'; 
							  if($value["action_remark"]!="") echo("(".$value["action_remark"].")");}

							  
							  
							  else if($value['action_status']=='AT'){echo '<label style="color:#8ad919">ActionTaken</label>';} else if($value['action_status']=='C'){echo '<label style="color:green">Completed</label>';} ?></label>
							  </td>



                              <td><?php if($value["deadline_dt"]!="0000-00-00") echo db_dt_format($value["deadline_dt"]);?></td>
                              <td class="text-center"><label class="" id="<?php echo $value['action_id'] ;?>"><?php if($value['action_status']=='AT'){echo"<label class='accept_status btn btn-success btn-sm' id=".$value['action_id']."><i class='glyphicon glyphicon-ok'></i>&nbsp;&nbsp;Accept&nbsp;&nbsp;</label><label class='pending btn btn-warning btn-sm' id=".$value['action_id']."><i class='glyphicon glyphicon-stop'></i>&nbsp;Next Date</label>";}else if($value['action_status']=='C'){echo "<label  *class='accept_status' style='color:green'>Accepted</label>";}  
							    else if($value['action_status']=='P') echo "<label style='background-color:#9E9D24;border:1px solid #9E9D24; ' class='pending btn btn-warning btn-sm' id=".$value['action_id']."><i class='glyphicon glyphicon-stop'></i>&nbsp;Change Deadline</label>";?></label>
                              
                              <div class="shpanel"  id="<?php echo 'shpanel'.$value['action_id'];?>"  style="overflow-y : hidden; overflow-y : hidden; height: auto;width: auto; overflow-x : hidden; padding: 10px; border-radius: 10px; border: 2px solid #73AD21;" >
                                  <div class="form-group" style="display:" id="act_dt">
											<label for="deadline_dt" class="col-md-3 control-label">Deadline<span style="color:red; font-size:20px">*</span>:</label>
											<div class="col-md-12 has-success">
											<input class="datepicker form-control" data-date-format="dd/mm/yyyy" id="nxt_dt<?php echo $value['action_id'] ;?>" name="nxt_dt" >
											</div>
								  </div>
								  <div class="form-group" id="act_text" style="display:">
								   <div class="row">
									<label for="act_name" class="col-md-3 control-label">Remarks:</label>
									 <div class="col-md-12 has-success">
									 <input type="text" class="form-control" id="act_name<?php echo $value['action_id'] ;?>" name="act_name"  value="">
									</div>
								   </div>
								   </div>
 
								  
								  <a  class='next_date btn btn-success btn-sm'" id="<?php echo $value['action_id'];?>">Submit</a>
								</div>								  
                              </div>
							  </td>
                            </tr>
                            
                           <?php } ?>
                          </tbody>
                          </table>
                          </div>
                    <?php echo $links;?>
                    <input type="hidden" id="base_url" value="<?php echo base_url()?>">
                  </div>

            </div>
          </div>
        </div>
      </div>
    </div><!--/.row-->
    <script src='<?php echo base_url(); ?>style/js/rating.js'></script>
<script>

$( document ).ready(function() {
	$('.starrr_disable').unbind();
	$('.starbtn').on('starrr:change', function(e, value){
		/**console.log($(this).attr('data-id'));
		console.log(value);
		**/
		var base_url=$("#base_url").val();
		var dataId=$(this).attr('data-id');
		var url=base_url+"file_inbox/setRatingFileInbox/";
		$.ajax({url:url, 
			type:'post',
			data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo 	$this->security->get_csrf_hash(); ?>',dataId:dataId,ratingVal:value},
			success: function(result){
			}
		});
	});
});


 $(document).ready(function(){
    $(".status").click(function(){

      var base_url=$("#base_url").val();
     var id=$(this).attr("id");

      var url=base_url+"Letter_inbox/letter_action_status/";
      $.ajax({url:url, 
           type:'post',
           data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',id:id},
           success: function(result){
         $("#"+id).html(result);
    }});
     
  });
});

 $(document).ready(function(){
    $(".accept_status").click(function(){
  
      var base_url=$("#base_url").val();
     var id=$(this).attr("id");

      var url=base_url+"Letter_inbox/letter_status_accept/";
      $.ajax({url:url, 
           type:'post',
           data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',id:id},
           success: function(result){
         $("#"+id).html(result);
    }});
     
  });
});
$(document).ready(function(){
	
    $(".pending").click(function(){
		
    var idd='#shpanel'+$(this).attr("id");
	//alert(idd);
      $('.shpanel').not($(idd)).slideUp(800);
		$(idd).slideToggle();
		
		 // $(idd).scrollTo($(idd).right,$(idd).bottom);
        //$('html,body').animate({scrollTop: $(this).offset().top}, 800); 
    });
});
$(document).ready(function(){
    $(".next_date").click(function(){
  var idd='#shpanel'+$(this).attr("id");
      var base_url=$("#base_url").val();
	  var nxt_dt=($("#nxt_dt"+$(this).attr("id")).val());
	 // alert(nxt_dt);
	  var act_name=($("#act_name"+$(this).attr("id")).val());
     var id=$(this).attr("id");
     //alert(act_name);
      var url=base_url+"Letter_inbox/letter_status_postpond/";
	 // alert(url);
      $.ajax({url:url, 
           type:'post',
           data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',id:id,act_name:act_name,nxt_dt:nxt_dt},
           success: function(result){
			$(idd).slideToggle();  
         $("#"+id).html(result);
    }});
     
  });
});
</script>