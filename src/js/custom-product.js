jQuery(document).ready(function ($) {
  if (!productStatus.inStock) {
    $('.add_to_cart_button').hide(); // Hide add to cart button
    $('input.qty').hide(); // Hide quantity input
    // Add custom button
    $('.product').append('<button class="custom-button">Notify Me</button>');
  }
});
