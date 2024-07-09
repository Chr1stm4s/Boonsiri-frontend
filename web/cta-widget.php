<button class="social-icon-widget main bg-white shadow p-0 border-0" id="CTAWidgetToggle">
    <img src="https://911lust.rayoutdesign.com/widget/cta/cta-icon.svg" alt="<?=$ogTitle;?>">
</button>
<a href="https://lin.ee/ddCmohN" class="social-icon-widget widget-list shadow list-1 btn-tooltip" target="_blank" data-bs-title="แชทกับเราผ่าน LINE">
    <img src="<?=rootURL();?>images/cta-line.png" alt="<?=$ogTitle;?>">
</a>
<a href="https://m.me/197604500692653" class="social-icon-widget widget-list shadow list-2 btn-tooltip" target="_blank" data-bs-title="แชทกับเราผ่าน Messenger">
    <img src="<?=rootURL();?>images/cta-messenger.png" alt="<?=$ogTitle;?>">
</a>
<a href="https://www.tiktok.com/@boonsirifrozen" class="social-icon-widget widget-list shadow list-3 btn-tooltip" style="background-color: black;" target="_blank" data-bs-title="ติดตามเราที่ TikTok">
    <img src="<?=rootURL();?>images/cta-tiktok.svg" alt="<?=$ogTitle;?>">
</a>

<script>
    $("#CTAWidgetToggle").on("click", function() {
        $(".widget-list").toggleClass("active");
    });
</script>