$(function () {

  $('.cancel-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var reserve_date = $(this).attr('reserve_date');
    var reserve_part = $(this).attr('reserve_part');
    var reserve_part_id = $(this).attr('reserve_part_id');
    $('.modal-date span').text(reserve_date);
    $('.modal-part span').text(reserve_part);
    $('.modal-part input').val(reserve_part_id);
    $('.modal-date input').val(reserve_date);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});
