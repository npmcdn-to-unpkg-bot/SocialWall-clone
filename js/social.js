// Timeago translate
jQuery.timeago.settings.strings = {
   // environ ~= about, it's optional
   prefixAgo: "il y a",
   prefixFromNow: "d'ici",
   seconds: "moins d'une minute",
   minute: "environ une minute",
   minutes: "environ %d minutes",
   hour: "environ une heure",
   hours: "environ %d heures",
   day: "environ un jour",
   days: "environ %d jours",
   month: "environ un mois",
   months: "environ %d mois",
   year: "un an",
   years: "%d ans"
};


$(document).ready(function () {

  $("time.timeago").timeago();




  var controller = new ScrollMagic.Controller();

  $("#slideUp").each(function (index, elem) {
    var tween = TweenMax.fromTo(elem, 1, {
        alpha:0.5,
        y:150,
      },{
        alpha: 1,
        y:0
      }
    );
    new ScrollMagic.Scene({
      triggerElement: elem,
      triggerHook: "onEnter",
      offset: -60,
    })
    .setTween(tween)
    .addTo(controller)
  });





});
