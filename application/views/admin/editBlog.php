<style>
   .note-popover .popover-content, .panel-heading.note-toolbar {
   padding: 0 0 10px 5px !important;
   margin: 0 !important;
   }
   .note-editor .note-editing-area {
   position: relative;
   margin-top: 5px;
   }
</style>
<div class="">
   <div class="page-title">
      <div class="title_left">
         <h3>Manage <?= $title; ?></h3>
      </div>
   </div>
   <hr noshade>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
		<div id="msge"></div>
         <div class="x_panel">
            <div class="x_title">
               <h2><?= $title; ?> |<small>Edit</small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="col-md-10 col-md-offset-1">
                  <form class="form-horizontal" method="post" id="Editform" action="<?= base_url();?>admin/Blogs/EditRecord">
                     <div class="col-md-12">
					  <div class="form-group">
                        <label class="control-label" for="example-text-input">Blog Title</label>
                        <input type="hidden" name="id" value="<?= $rec['id']; ?>">
                        <input type="text" name="title" value="<?= $rec['title']; ?>" placeholder="Enter Blog Title" class="form-control">
					  </div>
                     </div>
                     <div class="col-md-12">
                        <label class="control-label" for="example-text-input">Slug</label>
                        <input type="text" name="slug" value="<?= $rec['slug']; ?>" placeholder="Enter Blog Slug" class="form-control">
                     </div>
                     <div class="col-md-12">
                        <label class="control-label">Featured Image</label>
					  <div class="form-group">
						<div class="col-md-10">
                        <input type="file" name="image" class="form-control">
						</div>
						<div  class="col-md-2">
						<img src="<?=base_url();?>assets/uploads/blogs/<?= ($rec['image'] != "" ? $rec['image'] : "dummy.png"); ?>"  style="max-height:50px;" />
						</div>
					  </div>
                     </div>
                     <div class="col-md-12">
					  <div class="form-group">
                        <label class="control-label" for="example-text-input">Short Description</label>
                        <textarea name="description" placeholder="Enter Short Description" class="form-control" rows="3"><?= $rec['description']; ?></textarea>
						</div>
                     </div>
                     <div class="col-md-12">
					  <div class="form-group">
                        <label class="control-label" for="example-text-input">Blog Content</label>
                        <textarea name="content" class="summernote"><?= $rec['content']; ?></textarea>
					  </div>
                     </div>
                     <div class="col-md-12">
                        <input type="submit" id="addSubmit" value="Submit" class="btn btn-default" style="width:100%" >
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">        
   $(document).ready(function(){
   	$("#Addform").validate({
   		rules: {
   		  title: "required",
   		  slug: "required",
   		  image: "required",
   		  description: "required",
   		  content: "required"
   		}
   	});
   	$('.summernote').summernote({
   		placeholder: 'Enter Blog Content here...',
   		tabsize: 2,
   		height: 300
   	});
   });
   $(".btn-editc").click(function(){
   	var id=$(this).data("id");
   	$.ajax({
   		url:"<?= base_url();?>admin/condition/get_record",
   		type:'POST',
   		dataType:'JSON',
   		data:{'id':id},
   		success:function(result){
   			$('#id').val(result.id),
   			$('#title').val(result.title),
   			$("#summernote").summernote("code", result.description);
   		},
   		error: function (xhr, textStatus, errorThrown){
   			alert(xhr.responseText);
   		}
   	});
   });
</script>