jQuery(document).ready(function ($) {
  $(".site-header ul.menu").addClass("loaded");
  $(".site-header").append('<div class="subMenuWrapper" style="position: absolute;"></div>');

  var activeLI = null;

  $(".site-header ul.menu > li").on("mouseenter", function () {
      if (activeLI !== this) {
          if (activeLI) {
              $(activeLI).removeClass("active");
              $(".subMenuWrapper").empty().removeClass("active");
              $(activeLI).find(".menu-ad-image").show(); // Show the original ad image when another item is activated
          }
          activeLI = this;
      }

      var $this = $(this);
      if (!$this.find("a").first().is("#bookDemo")) {
          $this.addClass("active");
          $(".subMenuWrapper").addClass("active");

          var adImage = $this.find(".menu-ad-image").first().data("ad-image-url");
          var adLink = $this.find(".menu-ad-image").first().data("ad-link-url");

          var submenuContent = $this.find(".sub-menu").first().clone();
          submenuContent.removeClass("sub-menu").addClass("nested-menu");
          submenuContent.find("li").addClass("nested-menu-item");

          submenuContent.find("ul").each(function() {
              if ($(this).find("li").length > 0) {
                  submenuContent.addClass("nested-menu-has-children");
              }
          });

          $(".subMenuWrapper")
              .empty()
              .append(submenuContent)
              .append($("<a>", { href: adLink, target: "_blank" }).append($("<img>", { src: adImage, class: "menu-ad-image" })))
              .css("left", $this.offset().left + "px");

          var submenuHeight = submenuContent.outerHeight();
          $(".subMenuWrapper").css("min-height", submenuHeight < 200 ? "200px" : submenuHeight + "px");
      }
  });

  $(".site-header ul.menu > li, .subMenuWrapper").on("mouseleave", function () {
      setTimeout(() => {
          if (!$(".subMenuWrapper:hover").length && !$(activeLI).is(":hover")) {
              $(activeLI).removeClass("active");
              $(".subMenuWrapper").empty().removeClass("active");
              $(activeLI).find(".menu-ad-image").show(); // Restore visibility of the original ad image when mouse leaves
              activeLI = null;
          }
      }, 300);
  });

  $(".subMenuWrapper").on("mouseleave", function () {
      $(activeLI).removeClass("active");
      $(activeLI).find(".menu-ad-image").show(); // Restore visibility when leaving the submenu
      activeLI = null;
      $(".subMenuWrapper").empty().removeClass("active");
  });
});
