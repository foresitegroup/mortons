<?php global $jellythemes; ?>
<footer id="footer" class="section" role="contentinfo">
    <div class="container">
        <ul class="social">
            <?php if (isset($jellythemes['facebook']) && !empty($jellythemes['facebook'])) : ?>
            <li>
                <a target=“_blank” href="<?php echo esc_url($jellythemes['facebook']); ?>" class="icon fb"><i class="fa <?php echo $jellythemes['facebook_icon']; ?>"></i></a>
            <li>
            <?php endif; ?>
            <?php if (isset($jellythemes['twitter']) && !empty($jellythemes['twitter'])) : ?>
            <li>
                <a target=“_blank” href="<?php echo esc_url($jellythemes['twitter']); ?>" class="icon tw"><i class="fa <?php echo $jellythemes['twitter_icon']; ?>"></i></a>
            <li>
            <?php endif; ?>
            
            <?php if (isset($jellythemes['pinterest']) && !empty($jellythemes['pinterest'])) : ?>
            <li>
                <a target=“_blank” href="<?php echo esc_url($jellythemes['pinterest']); ?>" class="icon in"><i class="fa <?php echo $jellythemes['pinterest_icon']; ?>"></i></a>
            <li>
            <?php endif; ?>
            <?php if (isset($jellythemes['gplus']) && !empty($jellythemes['gplus'])) : ?>
            <li>
                <a target=“_blank” href="<?php echo esc_url($jellythemes['gplus']); ?>" class="icon go"><i class="fa <?php echo $jellythemes['gplus_icon']; ?>"></i></a>
            <li>
            <?php endif; ?>
        </ul>
    </div>
</footer>
<a href="#home" class="cd-top"><?php _e('Top', 'jellythemes'); ?></a>
<!-- BEGIN Scripts-->
<?php wp_footer(); ?>
</body>
</html>