<div class="row" id="comments">
	<div class="col-sm-12 commentsWrap">
		<div class="inner-spacer-right-lrg">

			<!--title-->
			<div class="row">
				<div class="col-sm-12">
					<h6 id="comments-title">
						<?php _e("Comments",'jellythemes'); ?> <span>( <?php comments_number('0','1','%'); ?> )</span>
					</h6>
				</div>
			</div>
			<ul class="commentlist">
				<?php wp_list_comments(array("callback"=> "jellythemes_comments_format")); ?>
			</ul>

			<div class="row">
				<div class="col-sm-12">
					<?php paginate_comments_links(); ?>
				</div>
			</div>

			<?php comment_form(); ?>
		</div>

	</div>
	<!--end comments wrap-->
</div>
