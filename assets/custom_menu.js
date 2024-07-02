jQuery(document).ready(function ($) {
  $(".site-header ul.menu").addClass("loaded");
  $(".site-header").append('<div class="subMenuWrapper"></div>');

  var activeLI = null;

  $(".site-header ul.menu > li").on("mouseenter", function () {
    if (activeLI !== this) {
      if (activeLI) {
        $(activeLI).removeClass("active");
        $(".subMenuWrapper").empty().removeClass("active");
        $(activeLI).find(".menu-icon").show(); // Show the original icon when another item is activated
      }
      activeLI = this;
    }

    var $this = $(this);
    if (!$this.find("a").first().is("#bookDemo")) {
      $this.addClass("active");
      $(".subMenuWrapper").addClass("active");

      // Clone the image element from the hovered menu item
      var iconUrl = $this.find(".menu-icon").first().data("icon-url");

      var submenuContent = $this.find(".sub-menu").first().clone();
      submenuContent.removeClass("sub-menu").addClass("nested-menu");
      submenuContent.find("li").addClass("nested-menu-item");

      $(".subMenuWrapper")
        .empty()
        .append(submenuContent)
        .append($("<img>", { src: iconUrl, class: "menu-icon" }))

        .css("left", $this.offset().left + "px");

      var submenuHeight = submenuContent.outerHeight();
      $(".subMenuWrapper").css(
        "min-height",
        submenuHeight < 200 ? "200px" : submenuHeight + "px"
      );
    }
  });

  $(".site-header ul.menu > li, .subMenuWrapper").on("mouseleave", function () {
    setTimeout(() => {
      if (!$(".subMenuWrapper:hover").length && !$(activeLI).is(":hover")) {
        $(activeLI).removeClass("active");
        $(".subMenuWrapper").empty().removeClass("active");
        $(activeLI).find(".menu-icon").show(); // Restore visibility of the original icon when mouse leaves
        activeLI = null;
      }
    }, 300);
  });

  $(".subMenuWrapper").on("mouseleave", function () {
    $(activeLI).removeClass("active");
    $(activeLI).find(".menu-icon").show(); // Restore visibility when leaving the submenu
    activeLI = null;
    $(".subMenuWrapper").empty().removeClass("active");
  });
});
