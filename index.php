<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Manajemen Blog (CMS)</title>
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --primary: #2563eb;
      --primary-h: #1d4ed8;
      --danger: #dc2626;
      --danger-h: #b91c1c;
      --success: #16a34a;
      --bg: #f1f5f9;
      --sidebar: #1e293b;
      --sidebar-h: #0f172a;
      --card: #ffffff;
      --border: #e2e8f0;
      --text: #1e293b;
      --muted: #64748b;
      --radius: 8px;
    }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* HEADER */
    header {
      background: var(--sidebar);
      color: #fff;
      padding: 0 24px;
      height: 56px;
      display: flex;
      align-items: center;
      gap: 10px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .25);
    }

    header svg {
      flex-shrink: 0;
    }

    header .brand {
      display: flex;
      flex-direction: column;
    }

    header .brand h1 {
      font-size: 16px;
      font-weight: 700;
      line-height: 1.2;
    }

    header .brand span {
      font-size: 11px;
      color: #94a3b8;
    }

    /* LAYOUT */
    .layout {
      display: flex;
      flex: 1;
    }

    /* SIDEBAR */
    aside {
      width: 220px;
      background: var(--sidebar);
      color: #fff;
      padding: 20px 0;
      flex-shrink: 0;
    }

    aside .menu-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .08em;
      color: #64748b;
      padding: 0 20px 8px;
      text-transform: uppercase;
    }

    aside nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 20px;
      color: #cbd5e1;
      text-decoration: none;
      font-size: 14px;
      transition: background .15s, color .15s;
      cursor: pointer;
    }

    aside nav a:hover {
      background: rgba(255, 255, 255, .07);
      color: #fff;
    }

    aside nav a.active {
      background: var(--primary);
      color: #fff;
    }

    aside nav a svg {
      flex-shrink: 0;
    }

    /* MAIN */
    main {
      flex: 1;
      padding: 28px;
      overflow-x: auto;
    }

    /* CARD */
    .card {
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
      overflow: hidden;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid var(--border);
    }

    .card-header h2 {
      font-size: 16px;
      font-weight: 600;
    }

    /* BUTTONS */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: background .15s, opacity .15s;
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
    }

    .btn-primary:hover {
      background: var(--primary-h);
    }

    .btn-danger {
      background: var(--danger);
      color: #fff;
    }

    .btn-danger:hover {
      background: var(--danger-h);
    }

    .btn-secondary {
      background: #e2e8f0;
      color: var(--text);
    }

    .btn-secondary:hover {
      background: #cbd5e1;
    }

    .btn-sm {
      padding: 4px 10px;
      font-size: 12px;
    }

    /* TABLE */
    .table-wrap {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    th {
      background: #f8fafc;
      text-align: left;
      padding: 10px 14px;
      font-size: 12px;
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .04em;
      border-bottom: 1px solid var(--border);
      white-space: nowrap;
    }

    td {
      padding: 12px 14px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: #f8fafc;
    }

    /* BADGE */
    .badge {
      display: inline-block;
      padding: 2px 10px;
      border-radius: 99px;
      font-size: 12px;
      font-weight: 600;
      background: #dbeafe;
      color: #1d4ed8;
    }

    /* AVATAR */
    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--border);
      background: #e2e8f0;
    }

    /* MODAL */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 200;
      align-items: center;
      justify-content: center;
    }

    .modal-overlay.open {
      display: flex;
    }

    .modal {
      background: #fff;
      border-radius: 12px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
      animation: modalIn .2s ease;
    }

    @keyframes modalIn {
      from {
        opacity: 0;
        transform: scale(.95) translateY(12px);
      }

      to {
        opacity: 1;
        transform: none;
      }
    }

    .modal-header {
      padding: 18px 22px 14px;
      border-bottom: 1px solid var(--border);
    }

    .modal-header h3 {
      font-size: 16px;
      font-weight: 700;
    }

    .modal-body {
      padding: 18px 22px;
    }

    .modal-footer {
      padding: 12px 22px 18px;
      display: flex;
      justify-content: flex-end;
      gap: 8px;
    }

    /* FORM */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .form-group {
      margin-bottom: 14px;
    }

    .form-group label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 5px;
      color: var(--text);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      font-size: 13px;
      color: var(--text);
      transition: border-color .15s;
      font-family: inherit;
      background: #fff;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 90px;
    }

    .form-hint {
      font-size: 11px;
      color: var(--muted);
      margin-top: 3px;
    }

    /* CONFIRM MODAL */
    .confirm-icon {
      text-align: center;
      padding: 24px 0 8px;
    }

    .confirm-icon svg {
      color: var(--danger);
    }

    .confirm-body {
      text-align: center;
      padding-bottom: 10px;
    }

    .confirm-body h3 {
      font-size: 17px;
      font-weight: 700;
      margin-bottom: 6px;
    }

    .confirm-body p {
      font-size: 13px;
      color: var(--muted);
    }

    /* TOAST */
    #toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #1e293b;
      color: #fff;
      padding: 12px 18px;
      border-radius: 8px;
      font-size: 14px;
      z-index: 999;
      opacity: 0;
      pointer-events: none;
      transition: opacity .3s;
      max-width: 320px;
    }

    #toast.show {
      opacity: 1;
    }

    #toast.success {
      border-left: 4px solid var(--success);
    }

    #toast.error {
      border-left: 4px solid var(--danger);
    }

    /* LOADING */
    .loading {
      text-align: center;
      padding: 40px;
      color: var(--muted);
      font-size: 14px;
    }

    .spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid #e2e8f0;
      border-top-color: var(--primary);
      border-radius: 50%;
      animation: spin .6s linear infinite;
      margin-right: 8px;
      vertical-align: middle;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .empty {
      text-align: center;
      padding: 48px;
      color: var(--muted);
      font-size: 14px;
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <header>
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round"
      stroke-linejoin="round">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
      <polyline points="14 2 14 8 20 8" />
      <line x1="16" y1="13" x2="8" y2="13" />
      <line x1="16" y1="17" x2="8" y2="17" />
      <polyline points="10 9 9 9 8 9" />
    </svg>
    <div class="brand">
      <h1>Sistem Manajemen Blog (CMS)</h1>
      <span>Blog Keren</span>
    </div>
  </header>

  <div class="layout">
    <!-- SIDEBAR -->
    <aside>
      <div class="menu-label">Menu Utama</div>
      <nav>
        <a id="nav-penulis" class="active" onclick="showSection('penulis')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
          Kelola Penulis
        </a>
        <a id="nav-artikel" onclick="showSection('artikel')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
          </svg>
          Kelola Artikel
        </a>
        <a id="nav-kategori" onclick="showSection('kategori')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" />
            <rect x="14" y="3" width="7" height="7" />
            <rect x="14" y="14" width="7" height="7" />
            <rect x="3" y="14" width="7" height="7" />
          </svg>
          Kelola Kategori
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main>

      <!-- ===== PENULIS ===== -->
      <div id="section-penulis">
        <div class="card">
          <div class="card-header">
            <h2>Data Penulis</h2>
            <button class="btn btn-primary" onclick="openTambahPenulis()">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Tambah Penulis
            </button>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tbody-penulis">
                <tr>
                  <td colspan="5" class="loading"><span class="spinner"></span>Memuat data...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== ARTIKEL ===== -->
      <div id="section-artikel" style="display:none">
        <div class="card">
          <div class="card-header">
            <h2>Data Artikel</h2>
            <button class="btn btn-primary" onclick="openTambahArtikel()">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Tambah Artikel
            </button>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Gambar</th>
                  <th>Judul</th>
                  <th>Kategori</th>
                  <th>Penulis</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tbody-artikel">
                <tr>
                  <td colspan="6" class="loading"><span class="spinner"></span>Memuat data...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===== KATEGORI ===== -->
      <div id="section-kategori" style="display:none">
        <div class="card">
          <div class="card-header">
            <h2>Data Kategori Artikel</h2>
            <button class="btn btn-primary" onclick="openTambahKategori()">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Tambah Kategori
            </button>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Nama Kategori</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tbody-kategori">
                <tr>
                  <td colspan="3" class="loading"><span class="spinner"></span>Memuat data...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- ============================================================ -->
  <!-- MODAL TAMBAH PENULIS -->
  <!-- ============================================================ -->
  <div class="modal-overlay" id="modal-tambah-penulis">
    <div class="modal">
      <div class="modal-header">
        <h3>Tambah Penulis</h3>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group"><label>Nama Depan</label><input type="text" id="tp-nama-depan" placeholder="Ahmad">
          </div>
          <div class="form-group"><label>Nama Belakang</label><input type="text" id="tp-nama-belakang"
              placeholder="Fauzi"></div>
        </div>
        <div class="form-group"><label>Username</label><input type="text" id="tp-username" placeholder="ahmad_f"></div>
        <div class="form-group"><label>Password</label><input type="password" id="tp-password"
            placeholder="••••••••••••"></div>
        <div class="form-group">
          <label>Foto Profil</label>
          <input type="file" id="tp-foto" accept="image/*">
          <p class="form-hint">Opsional. Maks 2 MB. Format: JPG, PNG, GIF, WEBP</p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-tambah-penulis')">Batal</button>
        <button class="btn btn-primary" onclick="simpanPenulis()">Simpan Data</button>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT PENULIS -->
  <div class="modal-overlay" id="modal-edit-penulis">
    <div class="modal">
      <div class="modal-header">
        <h3>Edit Penulis</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ep-id">
        <div class="form-row">
          <div class="form-group"><label>Nama Depan</label><input type="text" id="ep-nama-depan"></div>
          <div class="form-group"><label>Nama Belakang</label><input type="text" id="ep-nama-belakang"></div>
        </div>
        <div class="form-group"><label>Username</label><input type="text" id="ep-username"></div>
        <div class="form-group">
          <label>Password Baru (kosongkan jika tidak diganti)</label>
          <input type="password" id="ep-password" placeholder="••••••••••••">
        </div>
        <div class="form-group">
          <label>Foto Profil (kosongkan jika tidak diganti)</label>
          <input type="file" id="ep-foto" accept="image/*">
          <p class="form-hint">Maks 2 MB. Format: JPG, PNG, GIF, WEBP</p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-edit-penulis')">Batal</button>
        <button class="btn btn-primary" onclick="updatePenulis()">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <!-- ============================================================ -->
  <!-- MODAL TAMBAH ARTIKEL -->
  <!-- ============================================================ -->
  <div class="modal-overlay" id="modal-tambah-artikel">
    <div class="modal">
      <div class="modal-header">
        <h3>Tambah Artikel</h3>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Judul</label><input type="text" id="ta-judul" placeholder="Judul artikel...">
        </div>
        <div class="form-row">
          <div class="form-group"><label>Penulis</label><select id="ta-penulis"></select></div>
          <div class="form-group"><label>Kategori</label><select id="ta-kategori"></select></div>
        </div>
        <div class="form-group"><label>Isi Artikel</label><textarea id="ta-isi"
            placeholder="Tulis isi artikel di sini..."></textarea></div>
        <div class="form-group">
          <label>Gambar</label>
          <input type="file" id="ta-gambar" accept="image/*">
          <p class="form-hint">Wajib. Maks 2 MB. Format: JPG, PNG, GIF, WEBP</p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-tambah-artikel')">Batal</button>
        <button class="btn btn-primary" onclick="simpanArtikel()">Simpan Data</button>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT ARTIKEL -->
  <div class="modal-overlay" id="modal-edit-artikel">
    <div class="modal">
      <div class="modal-header">
        <h3>Edit Artikel</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ea-id">
        <div class="form-group"><label>Judul</label><input type="text" id="ea-judul"></div>
        <div class="form-row">
          <div class="form-group"><label>Penulis</label><select id="ea-penulis"></select></div>
          <div class="form-group"><label>Kategori</label><select id="ea-kategori"></select></div>
        </div>
        <div class="form-group"><label>Isi Artikel</label><textarea id="ea-isi"></textarea></div>
        <div class="form-group">
          <label>Gambar (kosongkan jika tidak diganti)</label>
          <input type="file" id="ea-gambar" accept="image/*">
          <p class="form-hint">Maks 2 MB. Format: JPG, PNG, GIF, WEBP</p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-edit-artikel')">Batal</button>
        <button class="btn btn-primary" onclick="updateArtikel()">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <!-- ============================================================ -->
  <!-- MODAL TAMBAH KATEGORI -->
  <!-- ============================================================ -->
  <div class="modal-overlay" id="modal-tambah-kategori">
    <div class="modal">
      <div class="modal-header">
        <h3>Tambah Kategori</h3>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Nama Kategori</label><input type="text" id="tk-nama"
            placeholder="Nama kategori..."></div>
        <div class="form-group"><label>Keterangan</label><textarea id="tk-ket"
            placeholder="Deskripsi kategori..."></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-tambah-kategori')">Batal</button>
        <button class="btn btn-primary" onclick="simpanKategori()">Simpan Data</button>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT KATEGORI -->
  <div class="modal-overlay" id="modal-edit-kategori">
    <div class="modal">
      <div class="modal-header">
        <h3>Edit Kategori</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ek-id">
        <div class="form-group"><label>Nama Kategori</label><input type="text" id="ek-nama"></div>
        <div class="form-group"><label>Keterangan</label><textarea id="ek-ket"></textarea></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('modal-edit-kategori')">Batal</button>
        <button class="btn btn-primary" onclick="updateKategori()">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <!-- ============================================================ -->
  <!-- MODAL KONFIRMASI HAPUS -->
  <!-- ============================================================ -->
  <div class="modal-overlay" id="modal-hapus">
    <div class="modal" style="max-width:360px">
      <div class="confirm-icon">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="3 6 5 6 21 6" />
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
        </svg>
      </div>
      <div class="confirm-body">
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
      </div>
      <div class="modal-footer" style="justify-content:center; gap:12px;">
        <button class="btn btn-secondary" onclick="closeModal('modal-hapus')">Batal</button>
        <button class="btn btn-danger" id="btn-konfirmasi-hapus">Ya, Hapus</button>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div id="toast"></div>

  <script>
    // ================================================================
    // HELPERS
    // ================================================================
    const $ = id => document.getElementById(id);
    const esc = s => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

    function showToast(msg, type = 'success') {
      const t = $('toast');
      t.textContent = msg;
      t.className = 'show ' + type;
      clearTimeout(t._timer);
      t._timer = setTimeout(() => t.className = '', 3000);
    }

    function openModal(id) { $(id).classList.add('open'); }
    function closeModal(id) { $(id).classList.remove('open'); }

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', e => { if (e.target === overlay) overlay.classList.remove('open'); });
    });

    // ================================================================
    // NAVIGATION
    // ================================================================
    function showSection(section) {
      ['penulis', 'artikel', 'kategori'].forEach(s => {
        $('section-' + s).style.display = s === section ? '' : 'none';
        $('nav-' + s).classList.toggle('active', s === section);
      });
      if (section === 'penulis') loadPenulis();
      if (section === 'artikel') loadArtikel();
      if (section === 'kategori') loadKategori();
    }

    // ================================================================
    // PENULIS
    // ================================================================
    function loadPenulis() {
      const tbody = $('tbody-penulis');
      tbody.innerHTML = '<tr><td colspan="5" class="loading"><span class="spinner"></span>Memuat data...</td></tr>';
      fetch('ambil_penulis.php')
        .then(r => r.json())
        .then(res => {
          if (!res.data.length) { tbody.innerHTML = '<tr><td colspan="5" class="empty">Belum ada data penulis.</td></tr>'; return; }
          tbody.innerHTML = res.data.map(p => `
        <tr>
          <td><img class="avatar" src="uploads_penulis/${esc(p.foto)}" alt="foto" onerror="this.src='uploads_penulis/default.png'"></td>
          <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
          <td>${esc(p.user_name)}</td>
          <td>${esc(p.password.substring(0, 12))}...</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="openEditPenulis(${p.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('penulis', ${p.id})">Hapus</button>
          </td>
        </tr>`).join('');
        })
        .catch(() => { tbody.innerHTML = '<tr><td colspan="5" class="empty">Gagal memuat data.</td></tr>'; });
    }

    function openTambahPenulis() {
      ['tp-nama-depan', 'tp-nama-belakang', 'tp-username', 'tp-password'].forEach(id => $(id).value = '');
      $('tp-foto').value = '';
      openModal('modal-tambah-penulis');
    }

    function simpanPenulis() {
      const namaDepan = $('tp-nama-depan').value.trim();
      const namaBelakang = $('tp-nama-belakang').value.trim();
      const username = $('tp-username').value.trim();
      const password = $('tp-password').value;
      if (!namaDepan || !namaBelakang || !username || !password) {
        showToast('Semua field wajib diisi', 'error'); return;
      }

      const fd = new FormData();
      fd.append('nama_depan', namaDepan);
      fd.append('nama_belakang', namaBelakang);
      fd.append('user_name', username);
      fd.append('password', password);
      const foto = $('tp-foto').files[0];
      if (foto) fd.append('foto', foto);

      fetch('simpan_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-tambah-penulis');
            showToast(res.message, 'success');
            loadPenulis();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    function openEditPenulis(id) {
      fetch('ambil_satu_penulis.php?id=' + id)
        .then(r => r.json())
        .then(res => {
          if (res.status !== 'success') { showToast(res.message, 'error'); return; }
          const p = res.data;
          $('ep-id').value = p.id;
          $('ep-nama-depan').value = p.nama_depan;
          $('ep-nama-belakang').value = p.nama_belakang;
          $('ep-username').value = p.user_name;
          $('ep-password').value = '';
          $('ep-foto').value = '';
          openModal('modal-edit-penulis');
        });
    }

    function updatePenulis() {
      const namaDepan = $('ep-nama-depan').value.trim();
      const namaBelakang = $('ep-nama-belakang').value.trim();
      const username = $('ep-username').value.trim();
      if (!namaDepan || !namaBelakang || !username) {
        showToast('Nama depan, nama belakang, dan username wajib diisi', 'error'); return;
      }

      const fd = new FormData();
      fd.append('id', $('ep-id').value);
      fd.append('nama_depan', namaDepan);
      fd.append('nama_belakang', namaBelakang);
      fd.append('user_name', username);
      fd.append('password', $('ep-password').value);
      const foto = $('ep-foto').files[0];
      if (foto) fd.append('foto', foto);

      fetch('update_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-edit-penulis');
            showToast(res.message, 'success');
            loadPenulis();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    // ================================================================
    // ARTIKEL
    // ================================================================
    function loadArtikel() {
      const tbody = $('tbody-artikel');
      tbody.innerHTML = '<tr><td colspan="6" class="loading"><span class="spinner"></span>Memuat data...</td></tr>';
      fetch('ambil_artikel.php')
        .then(r => r.json())
        .then(res => {
          if (!res.data.length) { tbody.innerHTML = '<tr><td colspan="6" class="empty">Belum ada data artikel.</td></tr>'; return; }
          tbody.innerHTML = res.data.map(a => `
        <tr>
          <td><img class="avatar" src="uploads_artikel/${esc(a.gambar)}" alt="gambar" style="border-radius:6px;"></td>
          <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(a.judul)}</td>
          <td><span class="badge">${esc(a.nama_kategori)}</span></td>
          <td>${esc(a.nama_depan)} ${esc(a.nama_belakang)}</td>
          <td style="white-space:nowrap;font-size:12px;color:var(--muted)">${esc(a.hari_tanggal)}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="openEditArtikel(${a.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('artikel', ${a.id})">Hapus</button>
          </td>
        </tr>`).join('');
        })
        .catch(() => { tbody.innerHTML = '<tr><td colspan="6" class="empty">Gagal memuat data.</td></tr>'; });
    }

    function loadDropdownPenulis(selectId, selectedId = null) {
      return fetch('ambil_penulis.php')
        .then(r => r.json())
        .then(res => {
          const sel = $(selectId);
          if (!res.data || !res.data.length) {
            sel.innerHTML = '<option value="">-- Tidak ada penulis --</option>';
            return;
          }
          sel.innerHTML = res.data.map(p =>
            `<option value="${p.id}" ${selectedId == p.id ? 'selected' : ''}>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</option>`
          ).join('');
        })
        .catch(() => { $(selectId).innerHTML = '<option value="">-- Gagal memuat --</option>'; });
    }

    function loadDropdownKategori(selectId, selectedId = null) {
      return fetch('ambil_kategori.php')
        .then(r => r.json())
        .then(res => {
          const sel = $(selectId);
          if (!res.data || !res.data.length) {
            sel.innerHTML = '<option value="">-- Tidak ada kategori --</option>';
            return;
          }
          sel.innerHTML = res.data.map(k =>
            `<option value="${k.id}" ${selectedId == k.id ? 'selected' : ''}>${esc(k.nama_kategori)}</option>`
          ).join('');
        })
        .catch(() => { $(selectId).innerHTML = '<option value="">-- Gagal memuat --</option>'; });
    }

    function openTambahArtikel() {
      ['ta-judul', 'ta-isi'].forEach(id => $(id).value = '');
      $('ta-gambar').value = '';
      Promise.all([loadDropdownPenulis('ta-penulis'), loadDropdownKategori('ta-kategori')])
        .then(() => openModal('modal-tambah-artikel'));
    }

    function simpanArtikel() {
      const judul = $('ta-judul').value.trim();
      const isi = $('ta-isi').value.trim();
      const gambar = $('ta-gambar').files[0];
      if (!judul || !isi) { showToast('Judul dan isi artikel wajib diisi', 'error'); return; }
      if (!gambar) { showToast('Gambar artikel wajib diunggah', 'error'); return; }

      const fd = new FormData();
      fd.append('judul', judul);
      fd.append('id_penulis', $('ta-penulis').value);
      fd.append('id_kategori', $('ta-kategori').value);
      fd.append('isi', isi);
      fd.append('gambar', gambar);

      fetch('simpan_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-tambah-artikel');
            showToast(res.message, 'success');
            loadArtikel();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    function openEditArtikel(id) {
      fetch('ambil_satu_artikel.php?id=' + id)
        .then(r => r.json())
        .then(res => {
          if (res.status !== 'success') { showToast(res.message, 'error'); return; }
          const a = res.data;
          $('ea-id').value = a.id;
          $('ea-judul').value = a.judul;
          $('ea-isi').value = a.isi;
          $('ea-gambar').value = '';
          Promise.all([
            loadDropdownPenulis('ea-penulis', a.id_penulis),
            loadDropdownKategori('ea-kategori', a.id_kategori)
          ]).then(() => openModal('modal-edit-artikel'));
        });
    }

    function updateArtikel() {
      const judul = $('ea-judul').value.trim();
      const isi = $('ea-isi').value.trim();
      if (!judul || !isi) { showToast('Judul dan isi artikel wajib diisi', 'error'); return; }

      const fd = new FormData();
      fd.append('id', $('ea-id').value);
      fd.append('judul', judul);
      fd.append('id_penulis', $('ea-penulis').value);
      fd.append('id_kategori', $('ea-kategori').value);
      fd.append('isi', isi);
      const gambar = $('ea-gambar').files[0];
      if (gambar) fd.append('gambar', gambar);

      fetch('update_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-edit-artikel');
            showToast(res.message, 'success');
            loadArtikel();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    // ================================================================
    // KATEGORI
    // ================================================================
    function loadKategori() {
      const tbody = $('tbody-kategori');
      tbody.innerHTML = '<tr><td colspan="3" class="loading"><span class="spinner"></span>Memuat data...</td></tr>';
      fetch('ambil_kategori.php')
        .then(r => r.json())
        .then(res => {
          if (!res.data.length) { tbody.innerHTML = '<tr><td colspan="3" class="empty">Belum ada data kategori.</td></tr>'; return; }
          tbody.innerHTML = res.data.map(k => `
        <tr>
          <td><span class="badge">${esc(k.nama_kategori)}</span></td>
          <td>${esc(k.keterangan || '-')}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="openEditKategori(${k.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('kategori', ${k.id})">Hapus</button>
          </td>
        </tr>`).join('');
        })
        .catch(() => { tbody.innerHTML = '<tr><td colspan="3" class="empty">Gagal memuat data.</td></tr>'; });
    }

    function openTambahKategori() {
      $('tk-nama').value = '';
      $('tk-ket').value = '';
      openModal('modal-tambah-kategori');
    }

    function simpanKategori() {
      const nama = $('tk-nama').value.trim();
      if (!nama) { showToast('Nama kategori wajib diisi', 'error'); return; }

      const fd = new FormData();
      fd.append('nama_kategori', nama);
      fd.append('keterangan', $('tk-ket').value.trim());

      fetch('simpan_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-tambah-kategori');
            showToast(res.message, 'success');
            loadKategori();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    function openEditKategori(id) {
      fetch('ambil_satu_kategori.php?id=' + id)
        .then(r => r.json())
        .then(res => {
          if (res.status !== 'success') { showToast(res.message, 'error'); return; }
          const k = res.data;
          $('ek-id').value = k.id;
          $('ek-nama').value = k.nama_kategori;
          $('ek-ket').value = k.keterangan || '';
          openModal('modal-edit-kategori');
        });
    }

    function updateKategori() {
      const nama = $('ek-nama').value.trim();
      if (!nama) { showToast('Nama kategori wajib diisi', 'error'); return; }

      const fd = new FormData();
      fd.append('id', $('ek-id').value);
      fd.append('nama_kategori', nama);
      fd.append('keterangan', $('ek-ket').value.trim());

      fetch('update_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.status === 'success') {
            closeModal('modal-edit-kategori');
            showToast(res.message, 'success');
            loadKategori();
          } else {
            showToast(res.message, 'error');
          }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi ke server', 'error'));
    }

    // ================================================================
    // KONFIRMASI HAPUS UNIVERSAL
    // ================================================================
    function konfirmasiHapus(tipe, id) {
      openModal('modal-hapus');
      $('btn-konfirmasi-hapus').onclick = () => hapusData(tipe, id);
    }

    function hapusData(tipe, id) {
      const map = { penulis: 'hapus_penulis.php', artikel: 'hapus_artikel.php', kategori: 'hapus_kategori.php' };
      const fd = new FormData();
      fd.append('id', id);

      fetch(map[tipe], { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          closeModal('modal-hapus');
          showToast(res.message, res.status === 'success' ? 'success' : 'error');
          if (res.status === 'success') {
            if (tipe === 'penulis') loadPenulis();
            if (tipe === 'artikel') loadArtikel();
            if (tipe === 'kategori') loadKategori();
          }
        })
        .catch(() => { closeModal('modal-hapus'); showToast('Terjadi kesalahan koneksi ke server', 'error'); });
    }

    // ================================================================
    // INIT
    // ================================================================
    loadPenulis();
  </script>
</body>

</html>