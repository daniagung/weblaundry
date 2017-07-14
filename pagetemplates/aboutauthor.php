<?php
defined('ABSPATH') or die();
?>							<div class="about-author bg_gray_3">
								<div class="media">
									<div class="pull-<?php print is_rtl()?"right":"left";?> text-center">
										<?php 
											$avatar_url = get_avatar_url(get_the_author_meta( 'ID' ),array('size'=>130 )); 
											if (isset($avatar_url)) {
										?>					
										<img src="<?php echo esc_url($avatar_url); ?>" class="author-avatar img-responsive img-circle" alt="<?php echo esc_attr(get_the_author_meta( 'nickname' )); ?>">
										<?php 
											} 
										?>											
									</div>
									<div class="media-body">
										<h5 class="heading_text_color"><?php printf(__('About %s','cleanco'),get_the_author_meta( 'nickname' )); ?></h5>
										<?php echo get_the_author_meta( 'description' ); ?>
									</div>
								</div>
							</div>
