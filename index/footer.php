	  <footer class="footer">
	  <center style="color:blue; margin-top:7px;">
	  <?php
	  if($_SESSION['user'] === SES_ADMIN){
	    echo "$name";
	  }else{
	    echo "©2015";
	  }
	  ?>
	  </center>
	  </footer>