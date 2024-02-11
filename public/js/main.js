

function toggleSidebar() {
  $("#sidebar-container").toggleClass("opened")

}

jQuery.fn.blindLeftToggle = function (duration, easing, complete) {
  return this.animate({
    marginLeft: parseFloat(this.css('marginLeft')) < 0 ? 0 : -this.outerWidth()
  }, jQuery.speed(duration, easing, complete));
};



function toggleSidebarDesktop() {
  var state = $('#sidebar-container').data('sidebar-state')
  if (state == 'expanded') {
    collapseSidebar()
  } else {
    expandSidebar()
  }

}

function collapseSidebar() {
  // $(".nav-item-text").css('visibility', 'hidden');
  // $("#brand-name").css('visibility', 'hidden');
  // $("#brand-name").css('overflow-x', 'hidden');
  $(".nav-item-text").css('opacity', '0');
  // $(".nav-item-text").animate({ width: '0%' });
  $("#sidebar-container").animate({ width: '4.3rem' });
  // $("#brand-image").addClass('img-fluid');


  $('#sidebar-container').data('sidebar-state', 'collapsed')
  localStorage.setItem('sidebarState', 'collapsed');
}

function expandSidebar() {
  // $(".nav-item-text").css('visibility', 'visible');
  $("#sidebar-container").animate({ width: '16rem' });
  $(".nav-item-text").css('opacity', '1');
  // $(".nav-item-text").animate({ width: '80%' });
  // $("#brand-name").css('visibility', 'visible');
  // $("#brand-name").css('overflow-x', 'unset');
  // $("#brand-image").removeClass('img-fluid');

  $('#sidebar-container').data('sidebar-state', 'expanded')
  localStorage.setItem('sidebarState', 'expanded');
}

$(".password-toggle").each(function() {
  var input = $(this).siblings("input");
  $(this).on("click", function() {
    input.attr("type", input.attr("type") === "password" ? "text" : "password")
    $(this).toggleClass("bx-show bx-hide")
  })
})