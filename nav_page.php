<?
echo " <hr>";
$max =  ceil($count / 10);
//echo "<hr> $count $max <hr>";

if($count != 0){
echo "

<nav>
  <ul class='pagination'>
    <li class='page-item'>
      <a class='page-link' href='#' aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
        <span class='sr-only'>Previous</span>
      </a>
    </li>
	";
for($i=1;$i<=$max;$i++){
	//if($limit_page == '0') $limit_page =1;;
	if($i == $limit_page){
		$style = " style='color: #FFF; background-color: #337AB7'"; 
	}else{
		$style = ' ';
	}
    echo " <li class='page-item' $style><a class='page-link' onclick='pageNav(\"$sd\", \"$ed\", \"$i\", \"$page_id\");' $style>$i</a></li>";
}
    
echo "
	<li class='page-item'>
      <a class='page-link' href='#' aria-label='Next'>
        <span aria-hidden='true'>&raquo;</span>
        <span class='sr-only'>Next</span>
      </a>
    </li>
  </ul>
</nav>
";
}
?>