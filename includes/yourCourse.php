<div class="your-course-container">
    <div class="video-container">
        <video
        id="my-video"
        class="video-js"
        controls
        preload="auto"
        poster="photos/course-miniature.jpg"
        data-setup="{}"
        >
            <source src="/Code1/videos/89818138_694521017753723_8841380106564796416_n.mp4" type="video/mp4" />
            <source src="MY_VIDEO.webm" type="video/webm" />
            <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
                >supports HTML5 video</a
            >
            </p>
        </video>
    </div>
    <div class="your-course-section">
        <div class="section-nav">
            <ul>
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                } else {
                    $id = "";
                }
                echo "<a href='/Code1/yourCourse/$id/courseDescription'><li><div class='nav-option active'>Opis kursu</div></li></a>
                <a href='/Code1/yourCourse/$id/courseOpinions'><li><div class='nav-option'>Opinie</div></li></a>";
                
            ?>
            </ul>
        </div>
        <div class="section-content">
        <?php
        if(isset($_GET['subPage'])){
            $subPage = $_GET['subPage'];
        } else {
            $subPage = "";
        }

       

        if($subPage == ""){
            echo "<div class='course-description'>
                <h1>O kursie nr $id</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, blanditiis ex optio dolorum error repellat non quod sed consectetur suscipit cum expedita laudantium illum maiores alias mollitia ullam delectus dicta. Mollitia necessitatibus inventore dolores? Temporibus, at illo labore error inventore minus odit voluptas fugiat officia blanditiis iusto iure, enim eius, provident minima fugit maxime similique rerum iste harum nobis nulla!</p>
            </div>";
        } else if ($subPage == "courseDescription"){
            echo "<div class='course-description'>
                <h1>O kursie nr $id</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, blanditiis ex optio dolorum error repellat non quod sed consectetur suscipit cum expedita laudantium illum maiores alias mollitia ullam delectus dicta. Mollitia necessitatibus inventore dolores? Temporibus, at illo labore error inventore minus odit voluptas fugiat officia blanditiis iusto iure, enim eius, provident minima fugit maxime similique rerum iste harum nobis nulla!</p>
            </div>";
        } else if ($subPage == "courseOpinions"){
            echo "<div class='course-opinions'>
                    opinie
                </div>";
        }
        ?>
            
            
        </div>
    </div>
</div>