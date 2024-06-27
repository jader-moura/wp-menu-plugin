<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}
/**** Shortcode for Successful Case Studies ****/
/*
* [successful_case_studies_slider numberposts="3" type="case-study"]
*/

class successful_case_studies_slider_shortcode {

    public function __construct() {
        add_action('init', [$this, 'register_shortcode']);
    }

    public function register_shortcode() {
        add_shortcode('successful_case_studies_slider', [$this, 'build_successful_case_studies_slider']);
    }

    public function build_successful_case_studies_slider($atts = []) {

        extract(shortcode_atts([
            'numberposts' => '',
            'type' => ''
        ], $atts));


		if (empty($numberposts)) {
			$numberposts = 3;
		}

        if (!empty($type)) {
            $taxQueries[] = [
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => array($type),
            ];
        }
		else{
			$taxQueries = [];
		}

        $posts = get_posts([
            'post_type' => array('resources'),
            'numberposts' => $numberposts,
            'tax_query' => $taxQueries,
            'orderby'          => 'date',
            'order'            => 'DESC',
        ]);

		/** Inject CSS & JS **/
		wp_enqueue_style('swiper-slider','https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',array(),null);
		wp_enqueue_script('swiper-slider', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), null, true);

		ob_start();
		?>
		<style>

        .sliderSuccessCaseStudies{
            width: 100%;
        }

        #sliderSuccessCaseStudies .swiper-wrapper {
            transition: 0.2s !important;
        }

        .sliderSuccessCaseStudiesArrows{
            height: 60px;
            width: 115px;
            display: flex;
            gap: 15px;
        }

        .sliderSuccessCaseStudiesArrows .inner{
            display: flex;
        }

        .sliderSuccessCaseStudiesArrows .swiper-button-next2,
        .sliderSuccessCaseStudiesArrows .swiper-button-prev2 {
            cursor: pointer;
        }

        .sliderSuccessCaseStudiesArrows .swiper-button-disabled{
            opacity: 0.3;
            cursor: unset;
            pointer-events: none;
        }

        .sliderSuccessCaseStudiesArrows .swiper-button-next2:hover,
        .sliderSuccessCaseStudiesArrows .swiper-button-prev2:hover{
            opacity: 0.8;
        }

        /** **/
        .sliderSuccessCaseStudies .swiper-slide .inner{
            display: flex;
            background-color:#fff;
            border-radius: 12px;
            background: #fff;
            box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.16);
        }

        .sliderSuccessCaseStudies .swiper-slide .inner .left{
            padding: 60px 40px 20px 60px !important;
            flex: 0 0 auto;
            width: 60%;
        }

        .sliderSuccessCaseStudies .swiper-slide .inner .right{
            flex: 0 0 auto;
            width: 40%;
            height: 500px;
        }

        .sliderSuccessCaseStudies .recom {
            font-size: 16px !important;
            letter-spacing: 0.02em !important;
            line-height: 32px !important;
            text-align: left;
            color: #7c21b5 !important;
            margin-bottom: 8px !important;
        }

        .sliderSuccessCaseStudies .postTitle {
            font-weight: 600 !important;
            font-size: 38px !important;
            letter-spacing: 0.02em;
            line-height: 46px !important;
            color: #7c21b5 !important;
            margin-bottom: 8px !important;
        }

        .sliderSuccessCaseStudies .postContent{
            font-size: 18px !important;
            letter-spacing: 0.02em !important;
            line-height: 26px !important;
            color: #5a5a5a !important;
            margin-bottom: 20px !important;
        }

        .sliderSuccessCaseStudies .bottomButton{
            margin-top: 20px;
            display: block;
            width: fit-content;
            font-size: 18px !important;
            letter-spacing: 0.02em !important;
            line-height: 36px !important;
            color: #f91c61 !important;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .sliderSuccessCaseStudies .bottomButton svg{
            padding-top: 3px;
        }

        .sliderSuccessCaseStudies .bottomButton:hover {
            opacity: 0.8;
            transition: 0.2s;
        }

        .sliderSuccessCaseStudies .bottomButton:hover svg{
            margin-left: 5px;
        }

        .sliderSuccessCaseStudies .swiper-slide .inner{
            background-color: #fff !important;
            filter: drop-shadow(4px 6px 12px rgba(0, 0, 0, 0.16));
            border-radius: 8px !important;

        }

        .sliderSuccessCaseStudies .sliderBottomContent {
            margin-top: 40px !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sliderSuccessCaseStudies .swiper-slide .inner .right img{
                max-width:100% !important;
                width: 100%;
                height: 500px !important;
                object-fit: cover;
                border-top-right-radius: 8px !important;
                border-bottom-right-radius: 8px !important;
            }

        .sliderSuccessCaseStudies .seeAllCaseStudies{
            width: 209px;
            height: 45px;
            border-radius: 12px !important;
            border: 2.5px solid #f91c61 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Open Sans";
            font-size: 18px;
            letter-spacing: 0.02em;
            color: #f91c61 !important;
            cursor: pointer;
        }

        .sliderSuccessCaseStudies .seeAllCaseStudies:hover{
            width: 209px;
            height: 45px;
            border-radius: 12px !important;
            background-color: #f91c61 !important;
            color: #fff !important;
            transition: 0.2s !important;
        }

        @media screen and (max-width: 992px) {
            .sliderSuccessCaseStudies .postTitle {
                font-size: 24px !important;
                line-height: 32px !important;
            }
        }

        @media screen and (max-width: 768px) {
            .sliderSuccessCaseStudies .swiper-slide .inner {
                flex-direction: column-reverse;
                padding: 30px !important;
            }

            .sliderSuccessCaseStudies .swiper-slide .inner .left{
                width: 100%;
                padding-right: 0 !important;
            }

            .sliderSuccessCaseStudies .swiper-slide .inner .right{
                width: 100%;

            }


            .sliderSuccessCaseStudies .swiper-slide .inner .right img{
                max-width:300px;
                margin:0 auto;
            }

            .sliderSuccessCaseStudies .postTitle {
                font-size: 24px;
                line-height: 32px;
            }

            .sliderSuccessCaseStudies .swiper-slide .inner .right img {
                height: auto !important;
                max-height: 250px;
                object-fit: contain;
                border-radius: unset !important;
            }

            .sliderSuccessCaseStudies .swiper-slide .inner .right{
                height: auto !important;
            }

            .sliderSuccessCaseStudies .swiper-slide .inner .left {
                padding: 0px 0px 20px 0px !important;
            }
        }

        @media screen and (max-width: 480px) {

            .sliderSuccessCaseStudies .swiper-slide .inner .right img{
                max-width:100% !important;
                margin:0 auto;
            }

            .sliderSuccessCaseStudies .sliderBottomContent {
                flex-direction: column;
                align-items: unset !important;
            }

            .sliderSuccessCaseStudies .sliderBottomContent .seeAllCaseStudies {
                margin-top: 40px !important;
            }

        }
        </style>

        <div id="sliderSuccessCaseStudies" class="sliderSuccessCaseStudies">

            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php foreach($posts as $post):?>

                <?php
                if (class_exists('WPSEO_Meta')) {
                    // Get the post's meta description using Yoast SEO
                    $meta_description = WPSEO_Meta::get_value('metadesc', $post->ID);
                }
                else{
                    $meta_description = '';
                }
                ?>

                <div class="swiper-slide eachSliderPost">
                    <div class="inner">
                        <div class="left">
                            <div class="recom">
                                RECOMMENDED CASE STUDY
                            </div>
                            <div class="postTitle">
                                <?=get_the_title($post->ID)?>
                            </div>
                            <div class="postContent">
                                <?=$meta_description?>
                            </div>
                            <div class="postBottom">
                                <a href="<?=get_the_permalink($post->ID)?>" class="bottomButton">
                                    Read More
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="8.822" height="15.521" viewBox="0 0 8.822 15.521"><g transform="translate(-9.724 1.061)"><g transform="translate(10.785)"><path d="M0,0,6.7,6.7,13.4,0" transform="translate(0 13.4) rotate(-90)" fill="none" stroke="#f91c61" stroke-linecap="round" stroke-width="1.5"/></g></g></svg></span>
                                </a>
                            </div>
                        </div>
                        <div class="right">
                            <?php if(has_post_thumbnail($post->ID)): ?>
                                <div class="postImg">
                                    <img src="<?=get_the_post_thumbnail_url($post->ID)?>" alt="<?=get_the_title($post->ID)?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- <div class="swiper-pagination"></div> -->
            <div class="sliderBottomContent">
                <div class="sliderSuccessCaseStudiesArrows">
                    <div class="swiper-button-prev2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72"><defs><style>.a{fill:#efefef;}.b{fill:none;stroke:#f91c61;stroke-linecap:round;stroke-linejoin:round;stroke-width:4px;}</style></defs><path class="b" d="M6123.964-13087.967,6110.6-13074.6l13.364,13.364" transform="translate(-6081.6 13110.467)"/></svg>
                    </div>
                    <div class="swiper-button-next2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72"><defs><style>.a{fill:#efefef;opacity:0.452;}.b{fill:none;stroke:#f91c61;stroke-linecap:round;stroke-linejoin:round;stroke-width:4px;opacity:0.497;}</style></defs><g transform="translate(-1730 -4218)"><path class="b" d="M6110.6-13087.967l13.364,13.364-13.364,13.364" transform="translate(-4350.964 17328.467)"/></g></svg>
                    </div>
                </div>
                <div class="seeAllCaseStudies">See All Case Studies</div>
            </div>
        </div>




        <script>
        jQuery( document ).ready(function() {
            const swiper = new Swiper('.sliderSuccessCaseStudies', {
                direction: 'horizontal',
                navigation: {
                    nextEl: ".swiper-button-next2",
                    prevEl: ".swiper-button-prev2",
                },
                breakpoints: {
                    320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    },
                    480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    },
                    768: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    },
                    1200: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    },
                },
                /*
                navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                },
                */

            });
        });
        </script>

		<?php
		$output = ob_get_clean();
		return $output;
    }
}

new successful_case_studies_slider_shortcode();
