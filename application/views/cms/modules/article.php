<div class="col-md-12">
    <div class="well col-md-11">
       
        <div class="col-md-6">
            <div class="pull-left">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">+Articles</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <input type="text" placeholder="Search" class="form-control"  />
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-lg-12">
   <?php
   ///var_dump($_SESSION);

   echo $msg;
   if(is_array($article))
        {
            foreach ($article as $value)
                {         
                    echo'
                        <div class="col-md-11">
                           <div class="media bg-grey" style="background: white !important; margin-top:10px;">
                             <div class="media-left media-middle">
                               <img src="'.IMGSRC.$value->thumbURL.'" class="media-object " style="height:100px;width: 100px;" class="" alt="'.$value->alt.'" >
                             </div>
                             <div class="media-body">
                               <h4 class="media-heading">'.$value->title.'</h4>
                              <p class="text-left text text-warning"><em>'.$value->author.'</em></p>
                               <p class="text-left text text-warning"><em>'.date('dS M Y h:i:sa',strtotime($value->publishdate)).'</em></p>
                             </div>
                           </div>
                        </div>';
                }
           echo $link;
        }
    ?>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="panel panel-primary">
            <div class="panel-heading">Add Article</div>
            <div class="panel-body">
                <div class="col-md-offset-1 col-md-10">
                    <?php echo form_open_multipart('cms/article/create','class="form form-horizontal btn-redirects" autocomplete="off" method="post" role="form"'); ?>
                    <div class="form-group">
                        <label class="col-md-4">Author</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="author" placeholder="Title for the article" autofocus="" value="<?=$this->session->userdata('Name'); ?>" />
                        </div>
                    </div>           
                    <div class="form-group">
                        <label class="col-sm-4">Category</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="category" required="" autofocus="">
                                <?php
                                    if(is_array($category))
                                        {
                                            foreach ($category as $val)
                                                {
                                                    echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                                } 
                                        }
                                                 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Title</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="title" placeholder="Title for the article" autofocus=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Summary</label>
                        <div class="col-md-8">
                            <textarea name="summary" required="" placeholder="Summary of your content" class="form-control" autofocus="" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Keywords</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="keywords" required="" placeholder="Keywords separated by ;" autofocus=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Homepage Order</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="home_list" required="" placeholder="Home order" min="0" autofocus=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Category Order</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="parent_list" required="" min="0" autofocus=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Content</label>
                        <div class="col-md-12">
                            <textarea required autofocus class="form-control summernote" name="content" placeholder="Enter your story" autofocus=""></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Image</label>
                        <div class="col-md-8">
                            <input  type="file" name="userfile" autofocus=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Thumbnail caption</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="caption" autofocus="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Image alternate text</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="alt"  autofocus=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Related Video</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="r_video" autofocus="" />
                        </div>
                    </div>
                    <div class="pull-right">
                    <button class="btn btn-primary btn-sm"  name="submit"  value="save"  type="submit">SAVE</button>

                    <button class="btn btn-primary btn-sm"  name="submit"  value="publish"  type="submit">PUBLISH</button>

                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">CLOSE</button>
                </div>
                </form>
            </div>
                           
            </div> 
            
                              
            </div>
        </div>
    </div>
</div>

