<?php include( "layout/header.php" ); ?>
<section class="section">
    <div class="section-body">
    	<div class='row'>
        	<div class="col-12 col-md-12 col-lg-12">
        		<div class="card">
        			<div class="card-header">
                        <div class="row w-100">
                            <div class="col-md-2">
                              <h4>Add Blog</h4>
                            </div>    
                            <div class="col-md-8">&nbsp;</div>
                            <div class="col-md-2">
                                <a href="index">
                                    <button class="btn btn-primary">Back</button>
                                </a>
                            </div>
                        </div>
        			</div>
        			<div class="card-body">
                        <form action='post_condition' method='post' enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div clas="form-group">
                                        <label>Blog Tiitle</label>
                                        <input type="text" class="form-control" name="blog_title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div clas="form-group">
                                        <label>Blog Description</label>
                                        <textarea name="blog_description" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Post Image</label>
                                        <input type="file" name="blog_image" class=form-control required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <button type="submit" name="uplod_post" class="btn btn-primary">POST</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <a href="index">
                                            <button type="button" class="btn btn-primary">Cancel</button>
                                        </a>    
                                    </div>                                    
                                </div>
                            </div>  
                        </form>                      
        			</div>
    			</div>
    		</div>
    	</div> 
    </div>
</section>
<?php include( "layout/footer.php" ); ?>
