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

<!-- -- CHAT MODAL -- -->
<div class="modal-overlay" id="modal-chat">
  <div class="modal" style="display:flex;flex-direction:column;height:70vh;max-height:600px;">
    <div class="modal-header">
      <div class="modal-title">Secure Match Chat</div>
      <div class="modal-close" onclick="closeModal('modal-chat')"><i class="ti ti-x"></i></div>
    </div>
    <div class="modal-body" id="chat-messages" style="flex:1;overflow-y:auto;display:flex;flex-direction:column;gap:12px;padding:16px;">
      <!-- Messages will load here -->
    </div>
    <div class="modal-footer" style="padding:12px;border-top:1px solid var(--border);display:flex;gap:10px;">
      <input type="hidden" id="chat-match-id" value="0">
      <input type="text" id="chat-input" class="form-input-app" style="flex:1;" placeholder="Type a message...">
      <button class="btn btn-primary" onclick="sendMessage()"><i class="ti ti-send"></i> Send</button>
    </div>
  </div>
</div>
<style>
.chat-msg { max-width:75%; padding:10px 14px; border-radius:14px; font-size:13px; line-height:1.4; position:relative; }
.chat-msg.mine { align-self:flex-end; background:var(--cyan); color:var(--navy); border-bottom-right-radius:4px; }
.chat-msg.theirs { align-self:flex-start; background:var(--navy3); color:var(--txt); border:1px solid var(--border); border-bottom-left-radius:4px; }
.chat-sender { font-size:10px; font-weight:700; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px; }
.chat-msg.mine .chat-sender { color:rgba(0,0,0,0.5); }
.chat-msg.theirs .chat-sender { color:var(--txt3); }
</style>


<!-- -- IMAGE PREVIEW MODAL -- -->
<div class="modal-overlay" id="modal-image-preview">
  <div class="modal" style="width: auto; max-width: 90vw; text-align: center; background: transparent; box-shadow: none;">
    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
      <button class="btn" style="background: rgba(0,0,0,0.5); color: white; border: none;" onclick="closeModal('modal-image-preview')"><i class="ti ti-x"></i> Close</button>
    </div>
    <img id="preview-img-src" src="" style="max-width: 100%; max-height: 80vh; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
  </div>
</div>

