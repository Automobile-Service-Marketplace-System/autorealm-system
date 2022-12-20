<?php

use app\components\FormItem;

?>


<ul class="job-vehicle-details">
    <li>
        <strong>Vehicle:</strong>
        Toyota GR Supra A91 CF Edition
    </li>
    <li>
        <strong>Reg No:</strong>
        QL 9904
    </li>
</ul>


<form class="maintenance-inspection-form">
    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>
    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value2" value="Passed" id="section1_value2">
                        <label for="section1_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1_value1" value="Passed" id="section1_value1">
                        <label for="section1_value1">Passed</label>
                    </div>
                    <div class="form-item--radio">
                        <input type="radio" name="section2_value2" value="Passed" id="section2_value2">
                        <label for="section2_value2">Not passed</label>
                    </div>
                </div>
                <?php
                FormItem::render(id: "section1_value1_remark", label: "Remark", name: "section1_value1_remark");
                ?>
            </div>
        </div>
    </section>
    <div class="maintenance-inspection-form__actions">
        <button class="btn btn--danger">Reset</button>
        <button class="btn">Create</button>
    </div>
</form>
