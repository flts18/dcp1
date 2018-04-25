<!--  <div class="row">
      <div class="col-md-12">
        
          <div class="panel-body"> -->


		  <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"><svg class="glyph stroked email"></svg>Paper Registration</div>
          <div class="panel-body">
            <div class="col-md-12">


             <?php echo validation_errors('<div style="color:red;">','</div>');?>
                 <?php if(isset($error)) echo '<span style="color:red">'.$error.'</span>';?>
                   <div class="form-group has-success">
                   <span style="color:green"><?php echo $this->session->flashdata('success_message'); ?></span>
                    </div>
                <?php if(isset($success))
                {
                echo $success."<br>";
                foreach($success_file as $key=>$value)
                {
                   echo $value."<br>";
                }
                }
                ?>
                  
                   
                

<!-- <div class="panel-body">
	<div class="container">
	<form class="well form-horizontal" action=" " method="post"  id="contact_form">
	<fieldset>
	<div class="panel panel-default">
	<div class="panel-heading">Paper Registration</div>
<div class="form-group"></div> -->



<?php echo form_open_multipart('letter_registration/letter_insert/',"class='form-horizontal'");?> 
<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Id No: <font color="red" size="4">*</font></label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
  <?php $data = array(
                                        'name'          => 'memono',
                                        'id'            => 'memono',
                                        'value'         => '',
                                        'class'        =>'form-control',
                                        'required'    =>'required',
                                        
                                        );
                      echo form_input($data);
                          
           
                   ?>
    </div>
  </div>
</div>

<!-- Text input-->
 <div class="form-group">
  <label class="col-md-4 control-label" >Previous Id No:</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-resize-vertical"></i></span>
  <textarea rows="1" name="pre_letter_no" id="pre_letter_no" placeholder="Previous Memo No." style="text-transform:uppercase" onblur="upper_str(this)" class="form-control"  type="text"><?php echo set_value('comments'); ?></textarea>
    </div>
  </div>
</div>


<!-- Text input-->
     
<div class="form-group">
  <label class="col-md-4 control-label">Issue Date: <font color="red" size="4">*</font> </label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		 <input class="datepicker form-control"  id="issue_dt" name="issue_dt" value="<?php echo date('d/m/Y') ?>" required>
    </div>
  </div>
</div>


 
 

<!-- Text input-->
      
<div class="form-group">
  <label class="col-md-4 control-label" >Subject: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
 <input type="text" spellcheck="true" class="form-control" id="ltr_sub" name="ltr_sub" required value="<?php echo set_value('ltr_sub'); ?>">
    </div>
  </div>
</div>

<!-- Text input-->
 
<div class="form-group">
  <label class="col-md-4 control-label" >Sender: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-th-large"></i></span>
            <input type="text" class="form-control" id="authority" name="authority" onkeyup="autocomplet()" required autocomplete="off">
            <input type="hidden" id="authority_id" name="authority_id" value="">
            <ul id="authority_list" class="list-group col-md-12 uli"></ul>
    </div>
  </div>
</div>

<div class="form-group" style="display:none" id="sub_div1">
  <label for="add_authority_name" class="col-md-4 control-label" onblur="upper-control">Other Type: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-ok"></i></span>
            <input type="text" spellcheck="true" class="form-control" onblur="upper_str(this)" id="add_authority_name" name="add_authority_name" value="<?php echo set_value('add_authority_name'); ?>">
    </div>
  </div>
</div>


<div class="form-group" style="display:none" id="email_1">
  <label for="email_sender_name" class="col-md-4 control-label" onblur="upper-control">Sender Name: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" spellcheck="true" class="form-control" onblur="upper_str(this)" id="email_sender_name" name="email_sender_name" value="<?php echo set_value('email_sender_name'); ?>">
    </div>
  </div>
 </div>
  
<div class="form-group" style="display:none" id="email_2">  
  <label for="email_add" class="col-md-4 control-label" onblur="upper-control">Email Address: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
            <input type="text" spellcheck="true" class="form-control" onblur="*upper_str(this)" id="email_add" name="email_add" value="<?php echo set_value('email_add'); ?>">
    </div>
  </div>
</div>


<div class="form-group" style="display:none" id="petitioner_1">
  <label for="petitioner_name" class="col-md-4 control-label" onblur="upper-control">Petitioner Name: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" spellcheck="true" class="form-control" onblur="upper_str(this)" id="petitioner_name" name="petitioner_name" value="<?php echo set_value('petitioner_name'); ?>">
    </div>
  </div>
 </div>
  
<div class="form-group" style="display:none" id="petitioner_2">  
  <label for="petitioner_add" class="col-md-4 control-label" onblur="upper-control">Petitioner Address: <font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
            <input type="text" spellcheck="true" class="form-control" onblur="upper_str(this)" id="petitioner_add" name="petitioner_add" value="<?php echo set_value('petitioner_add'); ?>">
    </div>
  </div>
</div>



<!-- Select Basic -->
   
   
   

<div class="form-group"> 
  <label class="col-md-4 control-label">Category of Paper: <font color="red" size="4">*</font> </label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select id="letter_cat" name="letter_cat" class="form-control selectpicker" required>
			<option value="" >--- Select one ---</option>
			<?php foreach($register as $value){ ?>
                    <option value="<?php echo $value['register_id']; ?>" ><?php echo $value['paper_type']; ?></option>
                   <?php }?>
    </select>
  </div>
</div>
</div>

<!-- Text input-->


<div class="form-group"> 
  <label class="col-md-4 control-label">Category of Register: <font color="red" size="4">*</font> </label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
    <select id="reg_type" name="reg_type" class="form-control selectpicker" required>
			<option value="" >--- Select one ---</option>
			 <?php foreach($register_type as $value){ ?>
                    <option value="<?php echo $value['reg_type_id']; ?>" ><?php echo $value['category_register']; ?></option>
                   <?php }?>
    </select>
  </div>
</div>
</div>
<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Register Serial No: </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
  <?php $data = array(
                                              'name'          => 'ref_sl',
                                              'id'            => 'ref_sl',
                                              'value'         => '',
                                              'class'        =>'form-control upper-control',
                                              
                                              'onkeypress'   =>' return event.charCode >= 48 && event.charCode <= 57',
                                              );
                            echo form_input($data);
                                
                 
                         ?>
    </div>
  </div>
</div>





<!-- Text input-->
<div class="form-group"> 
  <label class="col-md-4 control-label">Addressed to (Designation): <font color="red" size="4">*</font> </label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     <select id="designation" name="designation" class="form-control selectpicker"  required>
                      <option value="">---Select one---</option>
                        <?php foreach($designation as $value){ ?>
                        <option value="<?php echo $value['desig_id']; ?>" ><?php echo $value['desig_name']; ?></option>
                        <?php }?>
                                 
                                      
                    </select>
  </div>
</div>
</div>

<!-- Select Basic -->
   
   
   

<div class="form-group"> 
  <label class="col-md-4 control-label">Sending Option: <font color="red" size="4">*</font> </label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-share"></i></span>
    <select id="send_opt" name="send_opt" class="form-control selectpicker" onchange="documents()" required>
			<option value="a" >Send hard & soft copy </option>
			<option value="b">Send only hard copy</option>
			<option value="c">Send only soft copy</option>
			
    </select>
  </div>
</div>
</div>


<!-- File upload -->


<div class="form-group" id="pdf_doc" *style="display:none;">
  <label class="col-md-4 control-label" >PDF Paper(maximum size should be 6 MB):<font color="red" size="4">*</font> </label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt" style="font-size:18px"></i></span>
      <input class="form-control" id="letterfile" name="letterfile" type="file" required>
      </div>
	  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
    <input type="submit" class="btn btn-info" value="Submit" >

    
  </div>
	</div>

	</fieldset>
	</form>
	</div>
    </div><!-- /.container -->
	</div>
	 </div>
        
        
                
      </div>
    </div>
	
	
	
	<script type="text/javascript">
	
	function autocomplet() {
		
		var min_length = 0; 
	var csrf_test_name=$("input[name=csrf_test_name]").val();
	var keyword = $('#authority').val();
	
	var base_url=$("#base_url").val();
	var url=base_url+"letter_registration/search_authority/";
	//alert(url);
	if (keyword.length >min_length) {
		$.ajax({
			url: url,
			type: 'POST',
			data: {keyword:keyword,csrf_test_name:csrf_test_name},
			success:function(data){
				//alert("okk");
				$('#authority_list').show();
				$('#authority_list').html(data);
			}
		});
	} else {
		//alert(data);
		$('#authority_list').hide();
	}
} 

	function documents()
	{
		var abc = $('#send_opt').val();
		//alert(abc);exit;
		
		if(abc=='b')
		{
			
			$('#pdf_doc').hide();
			//$("#letterfile").prop('required',false);
			$('#letterfile').removeAttr('required');
			//$('#letterfile').attr('required',false);
			//$('#letterfile').rules('add', { required: false });
			$('#letterfile').val('');
		}
		else
		{
			$('#pdf_doc').show();
			$('#letterfile').attr('required',true);
			//$("#letterfile").prop('required',true);
			//$('#letterfile').attr('required',true);
			//$('#letterfile').rules('add', { required: true });
			
		}
	}
	
	
	</script>
	
	
	
	 <script type="text/javascript">

     

 $(document).ready(function(){
    $(".designation").change(function(){
      var base_url=$("#base_url").val();
      var token_name=$("#token_name").val();
      var hash=$("#hash").val();
      var designation=$("#designation").val();
      var url=base_url+"file_inbox/fetch_emp_name/";
       $.ajax({url:url, 
           type:'post',
           data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',designation:designation},
           success: function(result){
         $("#user_id").html(result);
    }});
     
  });
});

$(document).ready(function(){
    $(".section").change(function(){

      var base_url=$("#base_url").val();
      var token_name=$("#token_name").val();
      var hash=$("#hash").val();
       var designation=$("#designation").val();
      var section=$("#section").val();
      var url=base_url+"letter_inbox/fetch_emp_name/";
       $.ajax({url:url, 
           type:'post',
           data:{ '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',designation:designation,section:section},
           success: function(result){
           
         $("#user_id").html(result);
    }});
     
  });
});

 

function registercat() {
  var reg_type = $('#reg_type').val();
  var base_url=$("#base_url").val();
  var url=base_url+"letter_registration/registercat/";

  $.ajax({
      url: url,
      type: 'POST',
      data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',reg_type:reg_type},
      success:function(data){
         //alert(data);
        $('#ref_sl').val(data);
      }
    });
  
}
    </script>
	
	
   


