    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">

                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="footer-section">
                        <h3><?php bloginfo( 'name' ); ?></h3>
                        <p><?php bloginfo( 'description' ); ?></p>
                    </div>

                    <div class="footer-section">
                        <h3><?php esc_html_e( '빠른 링크', 'dalsoop' ); ?></h3>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'container'      => false,
                                'fallback_cb'    => '__return_false',
                            )
                        );
                        ?>
                    </div>

                    <div class="footer-section">
                        <h3><?php esc_html_e( '연락처', 'dalsoop' ); ?></h3>
                        <p>
                            <?php esc_html_e( '이메일:', 'dalsoop' ); ?>
                            <a href="mailto:tex02@naver.com">tex02@naver.com</a>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

            <div class="site-info">
                <p>
                    &copy; <?php echo date( 'Y' ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <?php esc_html_e( '- 모든 권리 보유', 'dalsoop' ); ?>
                </p>
                <p>
                    <?php
                    printf(
                        esc_html__( '%s 테마로 제작되었습니다', 'dalsoop' ),
                        '<a href="https://www.dalsoop.com">Dalsoop</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
