    <div id="overlay_option">
    <a href="#" class = 'esc_button' onclick="toggleDiv('overlay_option')"><i class="fa-regular fa-circle-xmark"></i></a>
        <div class="side_menu">
        <ul>
            <li>
            <button class='channel_name_2'><?php
            echo $channel["name"];
            ?></button>
            </li>
            <?php
                if($user['username'] == $channel['admin']){
                    echo "  <li><button onclick=\"showPage('overview')\">Overview</button></li>
                            <li><button onclick=\"showPage('channels')\">Channels</button></li>
                            <li><button onclick=\"showPage('members')\">Members</button></li>";
                }else{
                    echo "<li><button onclick=\"showPage('overview_user')\">Overview</button></li>";
                }
            ?>
            <li><button onclick="showPage('leave')">Leave Channel</button></li>
            <?php
                if($user['username'] == $channel['admin']){
                    echo "<li><button class = 'danger' onclick=\"showPage('delete')\">Delete Channel<i class='fa-solid fa-trash'></i></button></li>";
                }
            ?>
        </ul>
        </div>
        <div class="content">
        <?php
        if($user['username'] == $channel['admin']){
            echo "<div id=\"overview\" class=\"page active\">";
        }else{
            echo "<div id=\"overview\" class=\"page\">";
        }
        ?>
                <h1>Server Overview</h1>
                <?php
                    $current_group = $_SESSION['current_group'];
                    $group_query = mysqli_query($con,"SELECT * FROM channel WHERE id='$current_group'");
                    $group_row = mysqli_fetch_array($group_query);
                    $img = $group_row['group_img'];
                    $current_group_name = $channel["name"];
                ?>
                <form action = "index.php" method="POST" enctype="multipart/form-data">
                    <div class = "form_content">
                        <label class = "upfile" for="server-image-upd"><i class="fa-solid fa-circle-plus"></i></label>
                        <div class="container">
                            <img id="blah2" src=<?php echo $img; ?> alt="Planet image"/>
                            <p>We recommended an image size of atleast 512x512 for the server.</p>
                        </div>

                        <input type="file" id="server-image-upd" name="img" accept="image/*" onchange="readURL2(this);" hidden>
                        
                        <div class = "change_name">
                            <label class = "server_name_text" for="server-name">PLANET NAME</label>
                            <input type="text" id="server-name" name="server-name" value="<?php echo $current_group_name; ?>" required>
                        </div>
                        
                    </div>
                    <input class="button" type="submit" name="update_button" value="Update">
                </form>
                <br><br>
                <hr style="background-color: white; height: 1px; border: none;">
            </div>
        <script>
            function readURL2(input) {
                console.log("ok");
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah2').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
            <?php
            if($user['username'] == $channel['admin']){
                echo "<div id=\"overview_user\" class=\"page\">";
            }else{
                echo "<div id=\"overview_user\" class=\"page active\">";
            }
            ?>
                <h1>Server Overview</h1>
                <?php
                    $current_group = $_SESSION['current_group'];
                    $group_query = mysqli_query($con,"SELECT * FROM channel WHERE id='$current_group'");
                    $group_row = mysqli_fetch_array($group_query);
                    $img = $group_row['group_img'];
                    $current_group_name = $channel["name"];
                ?>
                <form action = "index.php" method="POST" enctype="multipart/form-data">
                    <div class = "form_content">
                        <div class="container">
                            <img src=<?php echo $img; ?> alt="your image"/>
                            <p>Only admin can alter the planet info like image and name.</p>
                        </div>

                        <!-- <input type="file" id="server-image" name="img" accept="image/*" onchange="readURL(this);" hidden> -->
                        
                        <div class = "change_name">
                            <label class = "server_name_text" for="server-name">PLANET NAME</label>
                            <input type="text" id="server-name" name="server-name" value="<?php echo $current_group_name; ?>"readonly >
                        </div>
                        
                    </div>
                </form>
                <br><br>
                <hr style="background-color: white; height: 1px; border: none;">
            </div>
            
            <div id="channels" class="page">
                <h1>Server Channels</h1>
                <hr style="background-color: white; height: 1px; border: none;">
                <form action="index.php" method="POST" id="DeleteForm">
                    <input type="hidden" id="selectedValue" name="selectedValue">
                    <h2>TEXT CHANNELS 
                    <a href='#' onclick="toggleDiv('overlay_add_text_channel')"><i class='fa-solid fa-plus'></i></a>
                    </h2>
                        <?php
                            $channelname = $channel['text_channel'];
                            $channel_array = explode(",",$channelname);
                            foreach($channel_array as $value){
                                echo "<p># $value <button type='button' class ='deleteButton' value=\"$value,tc\"><i class='fa-solid fa-trash'></i></button></p>";
                            }
                        ?>
                    <hr style="background-color: white; height: 1px; border: none;">
                    <h2>VOICE CHANNELS
                    <a href='#' onclick="toggleDiv('overlay_add_text_channel')"><i class='fa-solid fa-plus'></i></a>
                    </h2>   
                        <?php
                            $channelname = $channel['voice_channel'];
                            $channel_array = explode(",",$channelname);
                            foreach($channel_array as $value){
                                echo "<p># $value <button type='button' class ='deleteButton' value=\"$value,vc\"><i class='fa-solid fa-trash'></i></button></p>";
                            }
                    ?>
                </form>
            </div>
            
            <div id="members" class="page">
                <h1>Server Members</h1>
                <div>
                    <?php
                        $count = 0;
                        $result = mysqli_query($con,$userlist_query);
                        while($row = $result->fetch_assoc()){
                            $user_group_array = explode(",",$row['group_id']);
                            if(in_array($channel_id,$user_group_array)){
                                $count++;
                            }
                        }
                        echo "<h1> $count Members</h1>";
                    ?>
                </div>

                <hr style="background-color: white; height: 1px; border: none;">

                <form action="index.php" method="POST" id="UserForm">
                        <input type="hidden" id="selecteduValue" name="selecteduValue">
                            <?php
                                if($result = mysqli_query($con,$userlist_query)){
                                    while($row = $result->fetch_assoc()){
                                    $user_group_array = explode(",",$row['group_id']);
                                        if(in_array($channel_id,$user_group_array)){
                                            $name = $row["first_name"] . " " . $row["last_name"];
                                            $username = $row["username"];
                                            $profile_pic = $row["profile_pic"];
                                            if($row['username'] == $channel['admin']){
                                                    echo    "<div class='user_list_item'>
                                                                <img src='$profile_pic'></img>
                                                                <p>$name</p>
                                                                <i style = 'color: #fee75c;' class='fa-solid fa-crown'></i>
                                                                <div class='user_option'>
                                                                        
                                                                </div>
                                                            </div>";
                                            }else{
                                                    echo    "<div class='user_list_item'>
                                                                <img src='$profile_pic'></img>
                                                                <p>$name</p>
                                                                <div class='user_option'>
                                                                    <button type='button' class='userButton' value=\"$username,kick\"><i style = 'color: #ed4245;' class='fa-solid fa-circle-xmark'></i></button>
                                                                    <button type='button' class='userButton' value=\"$username,ban\"><i style = 'color: #ed4245;' class='fa-solid fa-ban'></i></button>
                                                                    <button type='button' class='userButton' value=\"$username,transfer\"><i style = 'color: #fee75c;' class='fa-solid fa-crown'></i></button>
                                                                </div>
                                                            </div>";
                                            }
                                        }
                                    }
                                }
                            ?>
                </form>
            </div>
            <div id="leave" class="page">
                <h1>LEAVE <?php
                echo "'" . $channel["name"] . "'";
                ?> PLANET</h1>
                <div class="warning_area">
                    <p>Are you sure you want to leave <span><?php
                    echo  $channel["name"];
                    ?></span>.</p>
                </div>
                <form action="index.php" method="POST" id="DeleteForm">
                    <input class="danger_button" type="submit" name="leave_group" value="Leave">
                </form>
            </div>
            <div id="delete" class="page">
                <h1>DELETE <?php
                echo "'" . $channel["name"] . "'";
                ?> PLANET</h1>
                <div class="warning_area">
                    <p>Are you sure you want to delete <span><?php
                    echo  $channel["name"];
                    ?></span>. This action can not be undone.</p>
                </div>
                <form action="index.php" method="POST" id="DeleteForm">
                    <input class="danger_button" type="submit" name="delete_group" value="Delete">
                </form>
            </div>
        </div>
    </div>
    <script>
        const buttons = document.querySelectorAll('.deleteButton');
        const ubuttons = document.querySelectorAll('.userButton');

        // Add event listener to each button
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Set the value of the hidden input field to the value of the clicked button
                document.getElementById('selectedValue').value = this.value;
                // Submit the form
                document.getElementById('DeleteForm').submit();
            });
        });
        ubuttons.forEach(button => {
            button.addEventListener('click', function() {
                // Set the value of the hidden input field to the value of the clicked button
                document.getElementById('selecteduValue').value = this.value;
                // Submit the form
                console.log(this.value);
                document.getElementById('UserForm').submit();
            });
        });
        function showPage(pageId) {
            // Get all page elements
            const pages = document.querySelectorAll('.page');
            
            // Hide all pages
            pages.forEach(page => page.classList.remove('active'));
            
            // Show the selected page
            const selectedPage = document.getElementById(pageId);
            selectedPage.classList.add('active');
        }
    </script>
   