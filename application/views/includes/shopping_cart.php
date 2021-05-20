<?php $cartItems = $this->cart->contents(); ?>

<div class="shopping-cart" style="display: none;">
  <div class="shopping-cart-header">
    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge"><?php echo count($cartItems); ?></span>
    <div class="shopping-cart-total">
      <span class="lighter-text">Total:</span>
      <span class="main-color-text">$<?php echo $this->cart->format_number($this->cart->total()); ?></span>
    </div>
  </div> <!--end shopping-cart-header -->

  <ul class="shopping-cart-items">
    <?php foreach ($cartItems as $key => $item) { ?>
      <li class="clearfix">
        <a href="javascript:void(0);" class="removeCartItem" data-rowid="<?php echo $item['rowid']; ?>" data-action="<?php echo base_url("home/removeFromCart"); ?>"><i class="fa fa-close"></i></a>
        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" />
        <span class="item-name"><?php echo $item['name']; ?></span>
        <span class="item-price">$<?php echo $this->cart->format_number($item['price']); ?></span>
        <span class="item-quantity">Quantity: <?php echo $item['qty']; ?></span>
      </li>
    <?php } ?>
  </ul>

  <a href="#" class="btn btn-primary">Checkout</a>
</div> <!--end shopping-cart -->