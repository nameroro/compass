$(function () {

  $('.cancel-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var reserve_date = $(this).attr('reserve_date');
    var reserve_part = $(this).attr('reserve_part');
    var reserve_id = $(this).attr('reserve_id');
    $('.modal-date span').val(reserve_date);
    $('.modal-part span').val(reserve_part);
    $('.cancel-modal-hidden').val(reserve_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});
