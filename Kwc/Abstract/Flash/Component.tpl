<? if ($this->data->hasContent()) { ?>
    <div class="<?=$this->cssClass?> kwcAbstractFlash">
        <div class="flashWrapper"><?=$this->component($this->placeholder)?></div>
        <input type="hidden" class="flashData" value="<?= htmlspecialchars(Zend_Json::encode($this->flash)) ?>" />
    </div>
<? } ?>