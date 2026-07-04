<!-- ══ ITEM DETAIL MODAL ══ -->
<div class="modal-overlay" id="modal-item">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="modal-item-title">Item Details</div>
      <div class="modal-close" onclick="closeModal('modal-item')"><i class="ti ti-x"></i></div>
    </div>
    <div class="modal-body">
      <div id="modal-item-body"></div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal('modal-item')">Close</button>
      <button class="btn btn-primary" id="modal-claim-btn" onclick="openClaimModal();closeModal('modal-item')">Submit Claim</button>
    </div>
  </div>
</div>

<!-- ══ CLAIM MODAL ══ -->
<div class="modal-overlay" id="modal-claim">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Submit a Claim</div>
      <div class="modal-close" onclick="closeModal('modal-claim')"><i class="ti ti-x"></i></div>
    </div>
    <div class="modal-body">
      <div class="alert-banner cyan" style="margin-bottom:16px">
        <i class="ti ti-info-circle"></i>
        <span>Provide proof of ownership. Admin will verify and approve within 24 hours.</span>
      </div>
      <form method="POST" action="submit_claim.php">
        <input type="hidden" name="found_id" id="claim-found-id">
      <div class="form-field" style="margin-bottom:14px">
        <label class="form-label">How can you prove ownership?</label>
        <textarea name="proof_text" class="form-input-app" rows="3" placeholder="Describe the item in detail, including internal contents, serial numbers, or purchase history…" required></textarea>
      </div>
      <div class="form-field">
        <label class="form-label">Unique Identifying Marks</label>
        <input type="text" name="marks" class="form-input-app" placeholder="Sticker, engraving, serial number, name…">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn" onclick="closeModal('modal-claim')">Cancel</button>
      <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> Submit Claim</button>
    </div>
    </form>
  </div>
</div>

<!-- ══ EDIT LOST ITEM MODAL ══ -->
<div class="modal-overlay" id="edit-modal">

  <div class="modal-card">

    <div class="modal-head">
      <div class="modal-title">Edit Lost Item</div>
      <button class="modal-close" onclick="closeEditModal()"> × </button>
    </div>

    <form method="POST" action="update_lost.php">

      <input type="hidden"
             id="edit-id"
             name="lost_id">

      <div class="form-field">
        <label>Item Name</label>
        <input type="text"
               id="edit-name"
               name="item_name"
               class="form-input-app">
      </div>

      <div class="form-field">
        <label>Category</label>
        <input type="text"
               id="edit-category"
               name="category"
               class="form-input-app">
      </div>

      <div class="form-field">
        <label>Color</label>
        <input type="text"
               id="edit-color"
               name="color"
               class="form-input-app">
      </div>

      <div class="form-field">
        <label>Location</label>
        <input type="text"
               id="edit-location"
               name="location"
               class="form-input-app">
      </div>

      <div class="form-field">
        <label>Description</label>
        <textarea
          id="edit-description"
          name="description"
          class="form-input-app"></textarea>
      </div>

      <div class="form-actions">
        <button type="submit"
                class="btn btn-primary">
          Save Changes
        </button>
      </div>

    </form>

  </div>

</div>
