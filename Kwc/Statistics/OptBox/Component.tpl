<? if ($this->optComponent) { ?>
<div class="<?=$this->cssClass?>">
    <div class="inner">
        <?=$this->data->trlKwf('This website uses cookies to help us give you the best experience when you visit our website.')?>
        <? if ($this->optComponent) {
            echo $this->componentLink(
                $this->optComponent,
                $this->data->trlKwf('More information about the use of cookies'),
                'info'
            );
            echo $this->componentLink(
                $this->optComponent,
                '<span>' . $this->data->trlKwf('Accept and continue') . '</span>',
                array(
                    'cssClass' => 'accept',
                    'get' => array('optValue' => 'in')
                ),
                'accept'
            );
        }?>
    </div>
</div>
<? } ?>