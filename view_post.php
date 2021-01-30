<?php 
    include( "layout/header.php" ); 
    $post_details = array();
    $response_his = array();
    if( isset( $_POST['post_id'] ) )
    {
        $post_id        =   $_POST['post_id'];
        $select_query   =   "   SELECT * FROM bp_post_list bpl 
                                LEFT JOIN bp_user_register bur 
                                ON 
                                    bur.bur_user_register_id     =   bpl.bpl_post_created_by
                                WHERE 
                                    bpl.bpl_post_id     =   :post_id     
                            ";
        $prepare_post   =   $crud->prepare( $select_query );
        $prepare_post->bindParam( "post_id",$post_id );
        if( $prepare_post->execute() )
        {
            if( $get_post = $prepare_post->fetch() )
            {
                $post_details = $get_post; 
                $response_his = $crud->check_if_like_is_exist_or_not( $post_id,$_SESSION['user_details']['bur_user_register_id'] );
            }   
            else 
            {
                echo "  <script>
                            alert('Invalid post id.');
                            window.location.href='index';
                        </script>";       
            } 
        }   
        else 
        {
            echo "  <script>
                        alert('unable to process.');
                        window.location.href='index';
                    </script>";       
        }                 
    }   
    else 
    {
        echo "  <script>
                    window.location.href='index';
                </script>";
    } 
?>
<section class="section">
    <div class="section-body">
    	<div class='row'>
        	<div class="col-12 col-md-12 col-lg-12">
        		<div class="card">
        			<div class="card-header">
                        <div class="row w-100">
                            <div class="col-md-2">
                              <h4>View Blog</h4>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div clas="form-group">
                                    <label>Blog Tiitle</label>
                                    <p><?php echo $post_details['bpl_post_title'];  ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div clas="form-group">
                                    <label>Blog Description</label>
                                    <p><?php echo $post_details['bpl_post_description']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Post Image</label><br>
                                    <img class="post_img" src="post_images/<?php echo $post_details['bpl_post_image_name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group">
                                        <label>Comment...</label>
                                        <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row w-100">
                                    <?php
                                        if( $response_his['appresponse'] == "success" ) 
                                        {
                                    ?>
                                            <div id="like_count"><?php echo $post_details['bpl_post_likes']; ?></div>&nbsp;
                                            <button onclick="unlike( '<?php echo $post_details['bpl_post_id']; ?>' );" id="like_btn" class="btn btn-primary">UnLike</button>&nbsp;&nbsp;&nbsp;
                                    <?php
                                        }
                                        else 
                                        {
                                    ?>
                                            <div id="like_count"><?php echo $post_details['bpl_post_likes']; ?></div>&nbsp;
                                            <button onclick="like( '<?php echo $post_details['bpl_post_id']; ?>' );" id="like_btn" class="btn btn-primary">Like</button>&nbsp;&nbsp;&nbsp;
                                    <?php
                                        }
                                    ?>
                                    <button class="btn btn-primary">Comment</button>
                                </div>
                            </div>
                        </div>  
        			</div>
    			</div>
    		</div>
    	</div> 
    </div>
</section>
<?php include( "layout/footer.php" ); ?>