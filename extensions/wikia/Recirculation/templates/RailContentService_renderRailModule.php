<div id="WikiaAdInContentPlaceHolder" class="rail-sticky-module">
	<section id="recirculation-rail">
		<section class="rail-module premium-recirculation-rail">
			<?php if ( !empty( $popularPages ) ): ?>
			<h2><?= wfMessage( 'popularpages' )->escaped(); ?></h2>
			<ul class="thumbnails">
				<?php foreach ( $popularPages as $page ): ?>
				<li>
					<a href="<?= Sanitizer::encodeAttribute( $page['url'] ); ?>" title="<?= Sanitizer::encodeAttribute( $page['title'] ); ?>" data-tracking="rail">
						<?php if ( !empty( $page['thumbnail'] ) ): ?>
							<img src="<?= Sanitizer::encodeAttribute( $page['thumbnail'] ); ?>" alt=""/>
						<? else: ?>
							<div class="recirculation-rail__placeholder">
								<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.77.13L9.44 3.5a.66.66 0 0 1-.94 0L5.16.17a.44.44 0 0 0-.63 0L.24 4.4a.77.77 0 0 0-.24.55V9a.77.77 0 0 0 .23.55l8.37 8.37a.44.44 0 0 0 .63 0L17.6 9.5a.77.77 0 0 0 .23-.5V5a.77.77 0 0 0-.22-.54L13.4.13a.44.44 0 0 0-.63 0zm-2.66 4.94a.22.22 0 0 1 0-.3L12 2.88a1.65 1.65 0 0 1 1.41-.47 1.73 1.73 0 0 1 1 .51l1.91 1.91a.22.22 0 0 1 0 .3L13.39 8a.22.22 0 0 1-.3 0zm1 5.24l-1.8 1.8a.22.22 0 0 1-.3 0l-6-6A1.66 1.66 0 0 1 3 3.73l1.8-1.8a.22.22 0 0 1 .3 0l6 6a1.66 1.66 0 0 1 .01 2.38zm5.37-3.11v1.29a.57.57 0 0 1-.16.4l-6.89 7a.51.51 0 0 1-.38.17.54.54 0 0 1-.4-.17l-.49-.46a.22.22 0 0 1 0-.31l8-8a.22.22 0 0 1 .33.09zm-8.63 6a.75.75 0 0 1-.2.54l-.39.36a.33.33 0 0 1-.45 0L1.56 8.92a.69.69 0 0 1-.21-.49v-1A.39.39 0 0 1 2 7.18l5.57 5.5a.81.81 0 0 1 .28.54z"/>
								</svg>
							</div>
						<? endif; ?>
						<p><?= htmlspecialchars( $page['title'] ); ?></p>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<? endif; ?>
		</section>
	</section>
</div>
