<!-- ══ FILE A REPORT ══ -->
<div class="panel" id="panel-report">
  <div class="success-toast" id="submit-toast">
    <i class="ti ti-circle-check"></i>
    <div><strong>Report submitted successfully!</strong> Our matching engine will scan for potential matches. You'll be notified.</div>
  </div>

  <div class="form-tab-row">
    <div class="form-tab active" id="tab-lost-report" onclick="switchReportTab('lost')"><i class="ti ti-alert-triangle" style="font-size:14px"></i> Report Lost Item</div>
    <div class="form-tab" id="tab-found-report" onclick="switchReportTab('found')"><i class="ti ti-package" style="font-size:14px"></i> Report Found Item</div>
  </div>

  <!-- LOST FORM -->
  <form id="form-lost" class="form-card" method="POST" action="report_lost.php">
    <div class="form-section-title">Item Details</div>
    <div class="form-grid">
      <div class="form-field">
        <label class="form-label">Item Name *</label>
        <input type="text" class="form-input-app" name="item_name" placeholder="e.g. Samsung Galaxy S23 Black" required>
      </div>
      <div class="form-field">
        <label class="form-label">Category *</label>
        <select class="form-input-app" name="category" required>
          <option value="">Select category</option>
          <option>Electronics</option><option>Documents</option>
          <option>Accessories</option><option>Bags</option>
          <option>Clothing</option><option>Keys</option><option>Other</option>
        </select>
      </div>
      <div class="form-field">
        <label class="form-label">Color</label>
        <input type="text" class="form-input-app" name="color" placeholder="e.g. Black, metallic silver">
      </div>
      <div class="form-field">
        <label class="form-label">Date Lost *</label>
        <input type="date" class="form-input-app" name="lost_date" required>
      </div>
      <div class="form-field full">
        <label class="form-label">Location Lost *</label>
        <select class="form-input-app" name="location" required>
          <option value="">Select location</option>
          <option>Cafeteria / Canteen</option><option>Library (1st Floor)</option>
          <option>Library (2nd Floor)</option><option>Library (3rd Floor)</option>
          <option>ECE Department</option><option>CSE Department</option>
          <option>EEE Department</option><option>ME Department</option>
          <option>Admin Building</option><option>Main Gate / Entry</option>
          <option>Sports Ground</option><option>Residential Hall</option><option>Other</option>
        </select>
      </div>
      <div class="form-field full">
        <label class="form-label">Description</label>
        <textarea class="form-input-app" name="description" placeholder="Describe the item in detail — model, condition, any markings…"></textarea>
      </div>
      <div class="form-field full">
        <label class="form-label">Unique Identifying Marks</label>
        <input type="text" class="form-input-app" placeholder="e.g. Sticker on back, name written, serial number">
        <div class="form-hint">This helps verify ownership during claim verification.</div>
      </div>
    </div>
    <div class="form-section-title" style="margin-top:20px">Contact Preference</div>
    <div class="form-grid">
      <div class="form-field">
        <label class="form-label">Contact Phone (optional)</label>
        <input type="tel" class="form-input-app" placeholder="01XXXXXXXXX">
      </div>
      <div class="form-field">
        <label class="form-label">Preferred Contact Method</label>
        <select class="form-input-app">
          <option>Via Platform Notification</option>
          <option>Email</option><option>Phone</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button class="btn">Cancel</button>
      <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> Submit Lost Report</button>
    </div>
  </div>
  </form>

  <!-- FOUND FORM -->
  <form id="form-found" class="form-card" method="POST" action="report_found.php" style="display:none">

  <div class="form-section-title">Found Item Details</div>

  <div class="form-grid">

    <div class="form-field">
      <label class="form-label">Item Name *</label>
      <input
      type="text"
      class="form-input-app"
      name="item_name"
      placeholder="e.g. Black Android Phone"
      required>
    </div>

    <div class="form-field">
      <label class="form-label">Category *</label>
      <select
      class="form-input-app"
      name="category"
      required>
        <option value="">Select category</option>
        <option>Electronics</option>
        <option>Documents</option>
        <option>Accessories</option>
        <option>Bags</option>
        <option>Clothing</option>
        <option>Keys</option>
        <option>Other</option>
      </select>
    </div>

    <div class="form-field">
      <label class="form-label">Color / Appearance</label>
      <input
      type="text"
      class="form-input-app"
      name="color"
      placeholder="e.g. Black, metallic silver">
    </div>

    <div class="form-field">
      <label class="form-label">Date Found *</label>
      <input
      type="date"
      class="form-input-app"
      name="found_date"
      required>
    </div>

    <div class="form-field full">
      <label class="form-label">Location Found *</label>
      <select
      class="form-input-app"
      name="location"
      required>
        <option value="">Select location</option>
          <option>Cafeteria / Canteen</option><option>Library (1st Floor)</option>
          <option>Library (2nd Floor)</option><option>Library (3rd Floor)</option>
          <option>ECE Department</option><option>CSE Department</option>
          <option>EEE Department</option><option>ME Department</option>
          <option>Admin Building</option><option>Main Gate / Entry</option>
          <option>Sports Ground</option><option>Residential Hall</option><option>Other</option>
      </select>
    </div>

    <div class="form-field full">
      <label class="form-label">Description</label>
      <textarea
      class="form-input-app"
      name="description"
      placeholder="Describe what you found — condition, contents visible, etc."></textarea>
    </div>

  </div>

  <div class="alert-banner cyan" style="margin-top:16px">
    <i class="ti ti-shield-check"></i>
    <span>
      Our system will <strong>automatically match</strong>
      this found item against active lost reports when you submit.
    </span>
  </div>

  <div class="form-actions">
    <button type="button" class="btn">Cancel</button>

    <button
    type="submit"
    class="btn btn-gold">
      <i class="ti ti-send"></i>
      Submit Found Report
    </button>
  </div>

</form>