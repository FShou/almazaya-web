<?php
/**
 * Dynamic program tail: DATA script (mcSwitch source) + lightbox scenes.
 * Mirrors the static tail one-for-one; only one branch ever prints.
 */
$almazaya_programs = almazaya_get_ordered_posts( 'program' );
$almazaya_data    = array();
foreach ( $almazaya_programs as $almazaya_prog ) {
	$almazaya_head = get_post_meta( $almazaya_prog->ID, '_almazaya_heading', true );
	$almazaya_data[ $almazaya_prog->post_name ] = array(
		'label' => $almazaya_prog->post_title,
		'head'  => $almazaya_head ? $almazaya_head : $almazaya_prog->post_title,
		'desc'  => $almazaya_prog->post_excerpt ? $almazaya_prog->post_excerpt : wp_trim_words( wp_strip_all_tags( $almazaya_prog->post_content ), 32 ),
		'items' => get_post_meta( $almazaya_prog->ID, '_almazaya_items', true ),
	);
}
$almazaya_json = str_replace( '</', '<\/', wp_json_encode( $almazaya_data ) );
?>
<script>
var mcDescs = <?php echo $almazaya_json; ?>;
function mcSwitch(scene,btn){
  var stage=document.getElementById('mc-stage'),peeks=document.querySelectorAll('.mc-peek');
  stage.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  stage.querySelector('[data-scene="'+scene+'"]').classList.add('active');
  peeks.forEach(function(p){p.classList.remove('active')});
  btn.classList.add('active');
  var lb=document.getElementById('mc-lightbox');
  lb.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  lb.querySelector('[data-scene="'+scene+'"]').classList.add('active');
  var d=mcDescs[scene]||mcDescs[Object.keys(mcDescs)[0]];
  document.getElementById('mc-label').innerHTML=d.label;
  document.getElementById('mc-heading').innerHTML=d.head;
  document.getElementById('mc-desc').innerHTML=d.desc;
  document.getElementById('mc-list').innerHTML=d.items;
}
function mcFullscreen(){
  var lb=document.getElementById('mc-lightbox');
  var active=document.querySelector('#mc-stage .mc-scene.active');
  lb.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  lb.querySelector('[data-scene="'+active.dataset.scene+'"]').classList.add('active');
  lb.classList.add('open');document.body.style.overflow='hidden';
}
function mcCloseLB(){document.getElementById('mc-lightbox').classList.remove('open');document.body.style.overflow='';}
document.addEventListener('keydown',function(e){if(e.key==='Escape')mcCloseLB()});
</script>
<!-- lightbox -->
<div class="mc-lightbox" id="mc-lightbox" onclick="if(event.target===this)mcCloseLB()">
  <div class="mc-lightbox-inner">
    <?php
    $almazaya_li = 0;
    foreach ( $almazaya_programs as $almazaya_prog ) :
      $almazaya_pimg = get_the_post_thumbnail_url( $almazaya_prog, 'large' );
      if ( ! $almazaya_pimg ) {
        $almazaya_pimg = almazaya_img( 'overseas_img_8730_min' );
      }
      ?>
      <div class="mc-scene<?php echo 0 === $almazaya_li ? ' active' : ''; ?>" data-scene="<?php echo esc_attr( $almazaya_prog->post_name ); ?>">
        <span class="modclass-badge"><?php echo esc_html( $almazaya_prog->post_title ); ?></span>
        <img class="mc-photo" src="<?php echo esc_url( $almazaya_pimg ); ?>" alt="<?php echo esc_attr( $almazaya_prog->post_title ); ?>">
      </div>
      <?php $almazaya_li++; ?>
    <?php endforeach; ?>
  </div>
  <button class="mc-lb-close" onclick="mcCloseLB()" aria-label="Tutup">×</button>
</div>
