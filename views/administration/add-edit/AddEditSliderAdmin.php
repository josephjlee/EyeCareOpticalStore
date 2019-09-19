<!-- tabs -->	<!-- services -->
<div class="line">
</div>
<div class="demo" id="optics">    
    <div class="container"> 
        <div class="w3ls-heading">
            <?php foreach ($title_page as $t): ?>
                <?php if ($t->id_menu == 9): ?>
                    <h3><?php echo $t->name_menu; ?></h3>
                <?php endif; ?>
            <?php endforeach; ?>

            <br/>
            <?php
            if (!empty($this->session->flashdata('message'))):
                echo $this->session->flashdata('message');
                $this->session->set_flashdata('message', '');
            endif;
            ?>
        </div>
        <div class="about-right" style="box-sizing: border-box;">
            <h2 style="text-indent: 20px; text-align: justify">Dodavanje slajdera</h2>
            <br>
            <h3 style="text-indent: 20px; text-align: justify"><a  href="<?php echo base_url(); ?>administration/admin/SliderAdmin">Nazad</a></h3>
        </div>
        <div>
            <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="error">', '</div>'); ?>
                        <?php echo form_open_multipart('', $form_slider); ?>
                        <table style="width: 50%;  padding: 10px; margin: 50px 50px; margin: 0px auto">
                            <tr>
                                <td style="padding: 10px">Naslov: </td>
                                <td style="padding: 10px"><?php echo form_input($form_title_slider); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span style="color: orangered; font-size: 0.8em; display:none; margin-left: 15px" class="tbTitleSliderCss"></span></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px">Tekst: </td>
                                <td style="padding: 10px"><?php echo form_textarea($form_text_slider); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span style="color: orangered; font-size: 0.8em; display:none; margin-left: 15px" class="taTextSliderCss"></span></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px">Ime slike: * </td>
                                <td style="padding: 10px"><?php echo form_input($form_name_pic_slider); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span style="color: orangered; font-size: 0.8em; display:none; margin-left: 15px" class="tbPicNameSliderCss"></span></td>
                            <tr>
                                <td style="padding: 10px">Slika: * </td>
                                <td style="padding: 10px"><?php echo form_upload($form_pic_slider); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span style="color: orangered; font-size: 0.8em; display:none; margin-left: 15px" class="fPicSliderCss"></span></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px"></td>
                                <td style="padding: 10px"><?php echo form_submit($form_add_submit); ?></td>
                            </tr>
                        </table>
                        <?php echo form_close(); ?>
                    </div>
                </div> <!-- / .col-md-8 -->
            </div> <!--/ .row -->
        </div> <!-- end sidetab container -->
    </div>
</div>
</div>
<!-- //tabs -->    <!-- services -->