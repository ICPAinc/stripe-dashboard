<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>

<select name="PracticeSpecialty<?php echo $param1; ?>" <?php echo $param2; ?>>
	<option selected="selected"></option>
    <option value="Acupuncture">Acupuncture</option>
    <option value="Ayurvedic Medicine">Ayurvedic Medicine</option>
    <option value="Babywearing Educator">Babywearing Educator</option>
    <option value="Biofeedback">Biofeedback</option>
    <option value="Birth Education">Birth Education</option>
    <option value="Counseling - prenatal">Counseling - prenatal</option>
    <option value="Counseling - postnatal">Counseling - postnatal</option>
    <option value="Cranial/Sacral">Cranial/Sacral</option>
    <option value="Chiropractic">Chiropractic</option>
    <option value="Chinese Medicine">Chinese Medicine</option>
    <option value="Doula Services">Doula Services</option>
    <option value="Family Counseling">Family Counseling</option>
    <option value="Gynecology">Gynecology</option>
    <option value="Holistic DO">Holistic DO</option>
    <option value="Holistic MD">Holistic MD</option>
    <option value="Holistic Obstetrics">Holistic Obstetrics</option>
    <option value="Holistic Psychologist">Holistic Psychologist</option>
    <option value="Holistic Women's Health">Holistic Women's Health</option>
    <option value="Homeopathy">Homeopathy</option>
    <option value="Hypnobirth Services">Hypnobirth Services</option>
    <option value="Kinesiology">Kinesiology</option>
    <option value="Lactation Consulting">Lactation Consulting</option>
    <option value="Massage">Massage</option>
    <option value="Massage - prenatal">Massage - prenatal</option>
    <option value="Medical Massage Therapist">Medical Massage Therapist</option>
    <option value="Midwifery">Midwifery</option>
    <option value="Naturopathy">Naturopathy</option>
    <option value="Neurosensory Reintegration">Neurosensory Reintegration</option>
    <option value="Nutrition">Nutrition</option>
    <option value="Oriental Medicine">Oriental Medicine</option>
    <option value="Pediatric Practitioner">Pediatric Practitioner</option>
    <option value="Reiki">Reiki</option>
    <option value="Yoga">Yoga</option>
	<option value="Yoga - prenatal">Yoga - prenatal</option>
</select>