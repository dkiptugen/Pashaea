<div class="container " >
    <div class="row" >
        <div class="col col-lg-6  col-md-12 col-sm-12" >
      <div class="featured pb-3" >
      <?php
        $count=1;
       foreach($featured as $value)
         {
            if($count==1)
            {
            echo'<figure>
               <a href="'.site_url('article/'.$value->id.'/'.$this->assist->slugify($value->title)).'">
                  <img src="'.base_url('images/'.$value->thumbURL).'" alt="" >
                  <figcaption><h3 >'.$value->title.'</h3></figcaption>
              </a>
            </figure>
            <div id="trending"></div>
        </div>
      </div>
        <div class="clearfix"></div><div class="col-12 col-lg-3 col-sm-12 col-md-6 ">';
         }
      else
        {
            echo '
                  <div class="card mt-3">
                    <a href="'.site_url('article/'.$value->id.'/'.$this->assist->slugify($value->title)).'">
                    <img class="card-img-top" src="'.base_url('images/'.$value->thumbURL).'" alt="Card image cap" style="height: 180px; width:100%; "></a>
                    <div class="card-block">
                      <h4 class="card-title " style="font-size: 13px; font-weight:700;"><a href="'.site_url('article/'.$value->id.'/'.$this->assist->slugify($value->title)).'">'.$value->title.'</a></h4>
                    </div>
                  </div>
                  
                ';
            }
            $count++;
    }
    ?>
        <div class="clearfix"></div>
              </div><div class="col-12  col-lg-3 col-md-6 col-sm-12">

       
      
        
        <!-- <h6 class="card-header text-primary font-weight-bold ">FOLLOW US</h6>
        <div class="card-block" style="background:rgb(255,255,255);">
          
          <ul class="nav nav-inline">
            <li class="nav-item bg-blue text-white">
              <a class="nav-link" href="http://www.facebook.com/" target="_blank"><i class="fa fa-facebook fa-sm" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://www.twitter.com/" target="_blank"><i class="fa fa-twitter fa-sm" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="//instagram.com/" target="_blank"><i class="fa fa-instagram fa-sm" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item"><a href="//plus.google.com/" target="_blank" class="nav-link"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
          </ul>            
        </div> -->
      
      <div class="featured2">
      <?php
      foreach($popular as $val)
       {
          echo'
                <div class="card mt-3">
                     <div class="row">
                       <div class="col col-md-5">
                        <a href="'.site_url('article/'.$val->id.'/'.$this->assist->slugify($val->title)).'">
                          <img class="card-img-left" src="'.base_url('images/'.$val->thumbURL).'" alt="'.$val->alt.'" style="width:100%; height: 100%;">
                        </a>
                       </div>
                       <div class="col col-md-7" >
                         <div class="card-block" style="padding:10px 0;">
                          <h4 class="card-title " style="font-size:12px; font-family: "Open Sans", sans-serif; font-weight: 900; margin: 0; padding: 0;">
                            <a href="'.site_url('article/'.$val->id.'/'.$this->assist->slugify($val->title)).'">
                           '.$val->title.'
                            </a>
                          </h4>
                         </div>
                       </div>
                     </div>
                   </div>';
        }
      ?>
       </div>
      </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="container-fluid wrapper mt-3">
    <div class="container category">
        <h1 class="alert-heading">Editors Choice</h1>
        <div class="card-deck">
        <?php
        if(is_array($editorschoice))
          {
            foreach($editorschoice as $val)
              {
                    echo'
                    <div class="card">
                      <img class="card-img-top img-fluid" src="'.base_url('images/'.$val->thumbURL).'" alt="'.$val->alt.'" class="img-fluid" style="width: 100%; height: 154px;">
                      <div class="card-block">
                        <h4 class="card-title"><a href="'.site_url('article/'.$val->id.'/'.$this->assist->slugify($val->title)).'">'.$val->title.'</a></h4>
                        
                        <p class="card-text text-right"><small class="text-muted">Last updated 3 mins ago</small></p>
                      </div>
                    </div>';
              }
          }
        ?>
          <!-- <div class="card">
            <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
            <div class="card-block">
              <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>              
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
          </div>
          <div class="card">
            <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
            <div class="card-block">
              <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
              
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
          </div> -->
          <!-- <div class="card">
            <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
            <div class="card-block">
              <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
              
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
          </div> -->
          
        </div>

    </div>
</div>

<div class="container">
  <hr />
  <div class="category">
    <div class="title"><h1>world In photos </h1></div>
    <div class="card-deck">
      <div class="card">
        <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
      <div class="card">
        <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
      <div class="card">
        <img class="card-img-top img-fluid" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
      <div class="card">
        <img class="card-img-top" src="assets/img/card-img.jpg" alt="Card image cap" class="img-fluid" style="width: 100%; height: 154px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="container category">
  <hr />
  <div class="title"><h1>Categories </h1></div>
  <div class="row">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
      <div class="card" >
          <div class="card-header">
              Sports
          </div>
        <img class="card-img-top img-fluid" src="assets/img/card-object.jpg" alt="Card image cap" style="width:100%; height: 214px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals </h4>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        <div class="card-block">
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-12  col-md-4 col-lg-4">
      <div class="card" >
          <div class="card-header">
              Politics
          </div>
        <img class="card-img-top img-fluid" src="assets/img/card-object.jpg" alt="Card image cap" style="width: 100%; height: 214px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        <div class="card-block">
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
      <div class="card" >
          <div class="card-header">
              Kenya
          </div>
        <img class="card-img-top img-fluid" src="assets/img/card-object.jpg" alt="Card image cap" style="width: 100%; height: 214px;">
        <div class="card-block">
          <h4 class="card-title">How to be single: Have Life Goals first, then relationship goals</h4>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        <div class="card-block">
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a>
        </div>
      </div>
    </div>
  </div>
</div>
