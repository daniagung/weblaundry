<?php
defined('ABSPATH') or die();
?>
						<div class="postinfo">
							<ul class="list-inline">
								<?php $categories = get_the_category_list(' ',', ',''); ?>
								<?php if (!empty($categories)) : ?>
								<li class="info_categories"><?php echo $categories; ?></li>
								<?php endif;  ?>

								<li class="info_date"><?php print get_the_date('d.m.Y');?></li>

								<?php $tags = get_the_tag_list(' ',', ',''); ?>
								<?php if (!empty($tags)) : ?>
								<li class="info_tags"><?php echo $tags; ?></li>
								<?php endif;  ?>

								<li class="info_share"><?php locate_template('pagetemplates/social-share.php',true,false); ?></li>
							</ul>
						</div>