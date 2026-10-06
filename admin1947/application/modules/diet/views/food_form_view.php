<div class="content-wrapper">
<section class="content">
<div style="padding: 15px 5px 30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

  <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: #1e293b; margin: 0 0 4px;">
        <i class="fa fa-cutlery" style="color: #00a896;"></i> 
        <?=$food ? 'Edit Food: ' . html_escape($food->name) : 'Add New Food Item';?>
      </h2>
      <p style="font-size: 13px; color: #64748b; margin: 0;">Configure baseline energy, macros, and micronutrients</p>
    </div>
    <a href="<?=base_url('diet/foods');?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600;">
      <i class="fa fa-arrow-left"></i> Back to Food Catalog
    </a>
  </div>

  <?php if($this->session->flashdata('flashmsg')): ?>
    <div style="margin-bottom: 16px;">
      <?=$this->session->flashdata('flashmsg');?>
    </div>
  <?php endif; ?>

  <div class="box box-primary" style="border-radius: 10px; border-top: 3px solid #00a896; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 24px;">
    <form action="<?=base_url($food ? 'diet/edit_food/' . $food->id : 'diet/add_food');?>" method="post">
      
      <div class="row">
        <div class="col-md-6 form-group">
          <label style="font-weight: 700; color: #334155;">Food Item Name <span class="text-danger">*</span></label>
          <input type="text" name="name" value="<?=html_escape($food->name ?? '');?>" class="form-control" placeholder="e.g. Oats Porridge with Milk" required style="height: 40px;">
        </div>
        <div class="col-md-6 form-group">
          <label style="font-weight: 700; color: #334155;">Food Category</label>
          <input type="text" name="category" value="<?=html_escape($food->category ?? 'General');?>" list="catListFull" class="form-control" style="height: 40px;">
          <datalist id="catListFull">
            <?php foreach($categories as $cat): ?>
              <option value="<?=html_escape($cat);?>">
            <?php endforeach; ?>
          </datalist>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 col-sm-6 form-group">
          <label style="font-weight: 700; color: #334155;">Serving Size</label>
          <input type="number" step="0.1" name="serving_size" value="<?=rtrim(rtrim(number_format($food->serving_size ?? 1, 2), '0'), '.');?>" class="form-control" required style="height: 40px;">
        </div>
        <div class="col-md-3 col-sm-6 form-group">
          <label style="font-weight: 700; color: #334155;">Serving Unit</label>
          <input type="text" name="serving_unit" value="<?=html_escape($food->serving_unit ?? 'serving');?>" class="form-control" placeholder="piece, bowl, grams" required style="height: 40px;">
        </div>
        <div class="col-md-3 col-sm-6 form-group">
          <label style="font-weight: 700; color: #334155;">Calories (kcal) <span class="text-danger">*</span></label>
          <input type="number" step="0.1" name="calories" value="<?=round($food->calories ?? 0);?>" class="form-control" required style="height: 40px;">
        </div>
        <div class="col-md-3 col-sm-6 form-group">
          <label style="font-weight: 700; color: #334155;">Diet Classification</label>
          <select name="is_veg" class="form-control" style="height: 40px;">
            <option value="1" <?=(isset($food->is_veg) && $food->is_veg) ? 'selected' : '';?>>Vegetarian</option>
            <option value="0" <?=(isset($food->is_veg) && !$food->is_veg) ? 'selected' : '';?>>Non-Vegetarian / Egg</option>
          </select>
        </div>
      </div>

      <!-- Macros Card -->
      <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <h4 style="font-size: 14px; font-weight: 800; color: #334155; text-transform: uppercase; margin: 0 0 16px;">
          <i class="fa fa-pie-chart" style="color: #00a896;"></i> Macronutrients Distribution (per serving)
        </h4>
        <div class="row">
          <div class="col-md-3 col-sm-6 form-group">
            <label style="color: #16a34a; font-weight: 700;">Protein (grams)</label>
            <input type="number" step="0.1" name="protein" value="<?=floatval($food->protein ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
          <div class="col-md-3 col-sm-6 form-group">
            <label style="color: #0284c7; font-weight: 700;">Carbohydrates (grams)</label>
            <input type="number" step="0.1" name="carbs" value="<?=floatval($food->carbs ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
          <div class="col-md-3 col-sm-6 form-group">
            <label style="color: #d97706; font-weight: 700;">Fats (grams)</label>
            <input type="number" step="0.1" name="fats" value="<?=floatval($food->fats ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
          <div class="col-md-3 col-sm-6 form-group">
            <label style="color: #7c3aed; font-weight: 700;">Dietary Fiber (grams)</label>
            <input type="number" step="0.1" name="fiber" value="<?=floatval($food->fiber ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
        </div>
      </div>

      <!-- Micros Card -->
      <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
        <h4 style="font-size: 14px; font-weight: 800; color: #334155; text-transform: uppercase; margin: 0 0 16px;">
          <i class="fa fa-flask" style="color: #0284c7;"></i> Key Micronutrients (per serving)
        </h4>
        <div class="row">
          <div class="col-md-4 col-sm-6 form-group">
            <label style="font-weight: 700; color: #334155;">Iron (mg)</label>
            <input type="number" step="0.1" name="iron" value="<?=floatval($food->iron ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
          <div class="col-md-4 col-sm-6 form-group">
            <label style="font-weight: 700; color: #334155;">Calcium (mg)</label>
            <input type="number" step="0.1" name="calcium" value="<?=floatval($food->calcium ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
          <div class="col-md-4 col-sm-6 form-group">
            <label style="font-weight: 700; color: #334155;">Vitamin C (mg)</label>
            <input type="number" step="0.1" name="vitamin_c" value="<?=floatval($food->vitamin_c ?? 0);?>" class="form-control" style="height: 38px;">
          </div>
        </div>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <a href="<?=base_url('diet/foods');?>" class="btn btn-default" style="padding: 10px 20px; font-weight: 600;">Cancel</a>
        <button type="submit" class="btn btn-primary" style="background: #00a896; border-color: #00a896; padding: 10px 25px; font-weight: 700;">
          <i class="fa fa-save"></i> <?=$food ? 'Update Food Item' : 'Save Food to Catalog';?>
        </button>
      </div>

    </form>
  </div>

</div>
</section>
</div>
