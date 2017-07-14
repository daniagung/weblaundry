<?php
defined('ABSPATH') or die();
?>
					<div class="postmetabottom">
						<div class="row">
							<div class="col-xs-4">
							</div>
							<div class="col-xs-8 text-right">
								<ul class="list-inline">
									<li><i class="icon-user-1"></i><?php the_author_link(); ?></li>
<?php if(comments_open() && (get_cleanco_option('dt-comment-open','')==1)):?>
									<li><i class="icon-comment-empty"></i><?php comments_number(__('No Comments','cleanco'),__('1 Comment','cleanco'),__('% Comments','cleanco')); ?></li>
<?php endif;?>
								</ul>
							</div>
						</div>
					</div>