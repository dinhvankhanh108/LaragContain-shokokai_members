<?php
/*
Template Name:アーカイブ_ソリマチ株式会社
*/
echo "category";
?>

<?php get_header(); ?>

<div id="contents_cms" class="clearfix">
<div class="inner">


<div class="nr_area">

<?php if( strstr( $_SERVER['REQUEST_URI'], 'category/movie' ) ): ?>
<h1>動画コンテンツ<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>
<p>商工会クラウドの概要や操作方法に関する動画や法令改正のポイントの動画などをご視聴いただけます。</p>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 4 );?>">
<?php echo $cat_name = get_the_category_by_ID( 4 ); ?></a></li>
<li><a href="<?php echo get_category_link( 5 );?>">
<?php echo $cat_name = get_the_category_by_ID( 5 ); ?></a></li>
<li><a href="<?php echo get_category_link( 6 );?>">
<?php echo $cat_name = get_the_category_by_ID( 6 ); ?></a></li>
	<li><a href="<?php echo get_category_link( 8 );?>">
<?php echo $cat_name = get_the_category_by_ID( 8 ); ?></a></li>
</ul>
<p>&nbsp;</p>
<p style="margin-top:20px;">動画タイトルをクリックすると、閲覧することができます。</p>

<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-01' ) ): ?>
<h1>FAQ一覧（商工会クラウド）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 13 );?>">
<?php echo $cat_name = get_the_category_by_ID( 13 ); ?></a></li>
<li><a href="<?php echo get_category_link( 14 );?>">
<?php echo $cat_name = get_the_category_by_ID( 14 ); ?></a></li>
<li><a href="<?php echo get_category_link( 15 );?>">
<?php echo $cat_name = get_the_category_by_ID( 15 ); ?></a></li>
<li><a href="<?php echo get_category_link( 16 );?>">
<?php echo $cat_name = get_the_category_by_ID( 16 ); ?></a></li>
</ul>
<p>&nbsp;</p>


<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-02' ) ): ?>
<h1>FAQ一覧（MA1）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 18 );?>">
<?php echo $cat_name = get_the_category_by_ID( 18 ); ?></a></li>
<li><a href="<?php echo get_category_link( 19 );?>">
<?php echo $cat_name = get_the_category_by_ID( 19 ); ?></a></li>
<li><a href="<?php echo get_category_link( 20 );?>">
<?php echo $cat_name = get_the_category_by_ID( 20 ); ?></a></li>
<li><a href="<?php echo get_category_link( 21 );?>">
<?php echo $cat_name = get_the_category_by_ID( 21 ); ?></a></li>
</ul>
<p>&nbsp;</p>

<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-03' ) ): ?>
<h1>FAQ一覧（コンバート）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 23 );?>">
<?php echo $cat_name = get_the_category_by_ID( 23 ); ?></a></li>
<li><a href="<?php echo get_category_link( 24 );?>">
<?php echo $cat_name = get_the_category_by_ID( 24 ); ?></a></li>
<li><a href="<?php echo get_category_link( 25 );?>">
<?php echo $cat_name = get_the_category_by_ID( 25 ); ?></a></li>
<li><a href="<?php echo get_category_link( 26 );?>">
<?php echo $cat_name = get_the_category_by_ID( 26 ); ?></a></li>
</ul>
<p>&nbsp;</p>

<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-04' ) ): ?>
<h1>FAQ一覧（MoneyLink）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 28 );?>">
<?php echo $cat_name = get_the_category_by_ID( 28 ); ?></a></li>
<li><a href="<?php echo get_category_link( 29 );?>">
<?php echo $cat_name = get_the_category_by_ID( 29 ); ?></a></li>
<li><a href="<?php echo get_category_link( 30 );?>">
<?php echo $cat_name = get_the_category_by_ID( 30 ); ?></a></li>
<li><a href="<?php echo get_category_link( 31 );?>">
<?php echo $cat_name = get_the_category_by_ID( 31 ); ?></a></li>
</ul>
<p>&nbsp;</p>

<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-05' ) ): ?>
<h1>FAQ一覧（MR1）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 33 );?>">
<?php echo $cat_name = get_the_category_by_ID( 33 ); ?></a></li>
<li><a href="<?php echo get_category_link( 34 );?>">
<?php echo $cat_name = get_the_category_by_ID( 34 ); ?></a></li>
<li><a href="<?php echo get_category_link( 35 );?>">
<?php echo $cat_name = get_the_category_by_ID( 35 ); ?></a></li>
<li><a href="<?php echo get_category_link( 36 );?>">
<?php echo $cat_name = get_the_category_by_ID( 36 ); ?></a></li>
</ul>
<p>&nbsp;</p>

<?php elseif( strstr( $_SERVER['REQUEST_URI'], 'category/faq-category-06' ) ): ?>
<h1>FAQ一覧（関連製品）<span class="fs2">－<?php $category = get_the_category(); $cat_name = $category[0]->cat_name; echo $cat_name; ?>－</span></h1>

<ul class="movie_category" style="margin:0 0 20px 0">
<li><a href="<?php echo get_category_link( 38 );?>">
<?php echo $cat_name = get_the_category_by_ID( 38 ); ?></a></li>
<li><a href="<?php echo get_category_link( 39 );?>">
<?php echo $cat_name = get_the_category_by_ID( 39 ); ?></a></li>
<li><a href="<?php echo get_category_link( 40 );?>">
<?php echo $cat_name = get_the_category_by_ID( 40 ); ?></a></li>
<li><a href="<?php echo get_category_link( 41 );?>">
<?php echo $cat_name = get_the_category_by_ID( 41 ); ?></a></li>
</ul>
<p>&nbsp;</p>


<?php else: ?>

<?php endif; ?>


<div id="mv">
<table style="margin:20px 0 0 0;">
<?php query_posts($query_string .'&order=modified'); ?>
<?php if(have_posts()):while(have_posts()):the_post(); ?>
<tr>

<td width="960px" style="padding:10px"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
</tr>
<?php endwhile;endif; ?>
</table>
</div>









<div class="clearfix"></div>
<!-- /.inner -->
</div>
<!-- /#contents -->
</div>

<?php get_footer(); ?>

</body>
</html>