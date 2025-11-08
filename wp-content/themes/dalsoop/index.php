<?php
/**
 * The main template file
 *
 * @package Dalsoop
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="content-area container">

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="entry-header">
                        <?php
                        if ( is_singular() ) :
                            the_title( '<h1 class="entry-title">', '</h1>' );
                        else :
                            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                        endif;
                        ?>

                        <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                            </span>
                            <span class="byline">
                                <?php echo esc_html__( '작성자:', 'dalsoop' ); ?>
                                <?php the_author(); ?>
                            </span>
                            <?php if ( has_category() ) : ?>
                            <span class="cat-links">
                                <?php echo esc_html__( '카테고리:', 'dalsoop' ); ?>
                                <?php the_category( ', ' ); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </header>

                    <?php if ( has_post_thumbnail() && is_singular() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        if ( is_singular() ) :
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( '페이지:', 'dalsoop' ),
                                'after'  => '</div>',
                            ) );
                        else :
                            the_excerpt();
                        ?>
                            <p><a href="<?php echo esc_url( get_permalink() ); ?>" class="button">
                                <?php echo esc_html__( '더 읽기', 'dalsoop' ); ?>
                            </a></p>
                        <?php
                        endif;
                        ?>
                    </div>

                    <?php if ( is_singular() && ( get_the_tags() || comments_open() || get_comments_number() ) ) : ?>
                    <footer class="entry-footer">
                        <?php if ( get_the_tags() ) : ?>
                        <div class="tags-links">
                            <?php echo esc_html__( '태그:', 'dalsoop' ); ?>
                            <?php the_tags( '', ', ' ); ?>
                        </div>
                        <?php endif; ?>
                    </footer>
                    <?php endif; ?>

                </article>

                <?php
                // Comments template for single posts/pages
                if ( is_singular() && ( comments_open() || get_comments_number() ) ) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>

            <?php
            // Pagination
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '&laquo; 이전', 'dalsoop' ),
                'next_text' => __( '다음 &raquo;', 'dalsoop' ),
            ) );
            ?>

        <?php else : ?>

            <div class="no-results">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( '내용을 찾을 수 없습니다', 'dalsoop' ); ?></h1>
                </header>

                <div class="page-content">
                    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                        <p><?php
                            printf(
                                wp_kses(
                                    __( '첫 글을 작성해보세요. <a href="%1$s">여기를 클릭하세요</a>.', 'dalsoop' ),
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                        ),
                                    )
                                ),
                                esc_url( admin_url( 'post-new.php' ) )
                            );
                        ?></p>
                    <?php elseif ( is_search() ) : ?>
                        <p><?php esc_html_e( '검색 결과가 없습니다. 다른 키워드로 검색해보세요.', 'dalsoop' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php else : ?>
                        <p><?php esc_html_e( '요청하신 내용을 찾을 수 없습니다.', 'dalsoop' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
