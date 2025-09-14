<div class="amd-table8-modal-overlay" id="columnModal" style="display:none;">
    <div class="amd-table8-modal">
        <div class="amd-table8-modal-header">
            <h3 class="amd-table8-modal-title">Manage Columns</h3>
            <button type="button" class="amd-table8-modal-close" onclick="closeColumnModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="amd-table8-modal-body">
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">
                Drag and drop to reorder columns. Uncheck to hide columns.
            </p>
            <ul class="amd-table8-column-list" id="columnList">
                {{-- JS will dynamically generate column items here --}}
            </ul>
        </div>
        <div class="amd-table8-modal-footer">
            <button type="button" class="amd-table8-reset-btn" onclick="resetColumns()">
                Reset to Default
            </button>
            <div class="amd-table8-modal-actions">
                <button type="button" class="amd-table8-modal-btn secondary" onclick="closeColumnModal()">
                    Cancel
                </button>
                <button type="button" class="amd-table8-modal-btn primary" onclick="applyColumnChanges()">
                    Apply Changes
                </button>
            </div>
        </div>
    </div>
</div>
