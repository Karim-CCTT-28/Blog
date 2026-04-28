@extends('layouts.main')

@section('title', 'مقال جديد')
@section('nav-add', 'active')

@push('styles')
<style>
    .editor-layout { display: grid; grid-template-columns: 1fr 280px; gap: 1.5rem; align-items: start; }

    /* Toolbar */
    .editor-toolbar {
        display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
        background: var(--bg2); border: 1px solid var(--card-border);
        border-radius: 12px 12px 0 0; padding: .75rem 1rem;
    }
    .toolbar-btn {
        width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--card-border);
        background: var(--card); color: var(--muted2, #94a3b8); cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: .85rem;
        transition: all .2s ease; font-family: serif;
    }
    .toolbar-btn:hover { background: rgba(124,58,237,.15); color: #a78bfa; border-color: rgba(124,58,237,.3); }
    .toolbar-sep { width: 1px; height: 24px; background: var(--card-border); margin: 0 .25rem; }

    /* Title input */
    .title-input {
        width: 100%; padding: 1.1rem 1.25rem;
        background: var(--bg2); border: 1px solid var(--card-border); border-top: none;
        color: var(--text); font-family: 'Cairo', sans-serif;
        font-size: 1.4rem; font-weight: 700; outline: none;
        transition: border-color .25s;
    }
    .title-input::placeholder { color: var(--muted); }
    .title-input:focus { border-color: rgba(124,58,237,.4); }

    /* Editor area */
    .editor-area {
        min-height: 420px; padding: 1.25rem;
        background: var(--bg2); border: 1px solid var(--card-border); border-top: none;
        border-radius: 0 0 12px 12px;
        color: var(--text); font-family: 'Cairo', sans-serif;
        font-size: 1rem; line-height: 1.85; outline: none;
        transition: border-color .25s;
    }
    .editor-area:focus { border-color: rgba(124,58,237,.4); }
    .editor-area:empty::before { content: attr(data-placeholder); color: var(--muted); }
    .editor-area img { max-width: 100%; border-radius: 8px; margin: .5rem 0; }
    .editor-area blockquote {
        border-right: 4px solid var(--accent); padding: .75rem 1rem;
        margin: 1rem 0; background: rgba(124,58,237,.08); border-radius: 0 8px 8px 0;
        color: var(--muted2, #94a3b8); font-style: italic;
    }

    /* Sidebar */
    .sidebar { display: flex; flex-direction: column; gap: 1rem; }
    .sidebar-card {
        background: var(--bg2); border: 1px solid var(--card-border);
        border-radius: 12px; overflow: hidden;
    }
    .sidebar-card-header {
        padding: .85rem 1.1rem; border-bottom: 1px solid var(--card-border);
        font-size: .85rem; font-weight: 700; color: var(--muted);
        letter-spacing: .04em; text-transform: uppercase;
    }
    .sidebar-card-body { padding: 1.1rem; }

    .btn-publish {
        width: 100%; padding: .9rem;
        background: linear-gradient(135deg, var(--accent), #5b21b6);
        border: none; border-radius: 10px; color: #fff;
        font-family: 'Cairo', sans-serif; font-size: 1rem; font-weight: 700;
        cursor: pointer; transition: all .3s ease; position: relative; overflow: hidden;
    }
    .btn-publish::before { content:''; position:absolute; top:0;left:-100%;right:0;bottom:0; background:linear-gradient(135deg,rgba(255,255,255,.15),transparent); transition:left .4s ease; }
    .btn-publish:hover::before { left:100%; }
    .btn-publish:hover { box-shadow: 0 8px 25px var(--accent-glow); transform: translateY(-2px); }
    .btn-publish:disabled { opacity:.6; cursor:not-allowed; transform:none; }

    .btn-draft {
        width: 100%; padding: .75rem;
        background: transparent; border: 1px solid var(--card-border);
        border-radius: 10px; color: var(--muted2, #94a3b8);
        font-family: 'Cairo', sans-serif; font-size: .9rem; font-weight: 600;
        cursor: pointer; transition: all .2s ease; margin-top: .6rem;
    }
    .btn-draft:hover { background: var(--card); color: var(--text); }

    /* File upload */
    .upload-zone {
        border: 2px dashed var(--card-border); border-radius: 10px;
        padding: 1.5rem 1rem; text-align: center; cursor: pointer;
        transition: all .25s ease; position: relative;
    }
    .upload-zone:hover { border-color: rgba(124,58,237,.4); background: rgba(124,58,237,.05); }
    .upload-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; }
    .upload-zone .icon { font-size: 1.8rem; margin-bottom: .5rem; }
    .upload-zone p { font-size: .82rem; color: var(--muted); }
    .upload-zone strong { color: var(--accent); }

    .char-count { font-size: .78rem; color: var(--muted); text-align: left; margin-top: .5rem; }

    @media(max-width: 900px) {
        .editor-layout { grid-template-columns: 1fr; }
        .sidebar { order: -1; }
    }
</style>
@endpush

@section('content')

<form id="article-form" method="POST" action="/add" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="content" id="contentInput">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
        <div>
            <h1 style="font-size:1.8rem;font-weight:900;background:linear-gradient(135deg,#fff,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">✏️ مقال جديد</h1>
        </div>
    </div>

    @if($errors->any())
    <div style="padding:.8rem 1rem;border-radius:10px;background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.3);color:#f87171;margin-bottom:1.25rem;font-size:.9rem;">
        @foreach($errors->all() as $err)<div>• {{ $err }}</div>@endforeach
    </div>
    @endif

    <div class="editor-layout">
        <!-- Main Editor -->
        <div>
            <div class="editor-toolbar">
                <button type="button" class="toolbar-btn" onclick="fmt('bold')" title="عريض"><b>B</b></button>
                <button type="button" class="toolbar-btn" onclick="fmt('italic')" title="مائل"><i>I</i></button>
                <button type="button" class="toolbar-btn" onclick="fmt('underline')" title="تسطير"><u>U</u></button>
                <div class="toolbar-sep"></div>
                <button type="button" class="toolbar-btn" onclick="fmt('insertUnorderedList')" title="قائمة">☰</button>
                <button type="button" class="toolbar-btn" onclick="fmt('insertOrderedList')" title="قائمة مرقمة">①</button>
                <button type="button" class="toolbar-btn" onclick="insertBlockquote()" title="اقتباس">❝</button>
                <div class="toolbar-sep"></div>
                <button type="button" class="toolbar-btn" onclick="fmt('justifyRight')" title="محاذاة يمين">⬛</button>
                <button type="button" class="toolbar-btn" onclick="fmt('justifyCenter')" title="توسيط">⬜</button>
                <button type="button" class="toolbar-btn" onclick="fmt('justifyLeft')" title="محاذاة يسار">▪️</button>
                <div class="toolbar-sep"></div>
                <button type="button" class="toolbar-btn" onclick="insertImage()" title="صورة">🖼</button>
            </div>

            <input class="title-input" type="text" id="title" name="title"
                   placeholder="عنوان المقال..." value="{{ old('title') }}" required>

            <div class="editor-area" id="output" contenteditable="true"
                 data-placeholder="ابدأ الكتابة هنا... يمكنك رفع ملف .docx من الشريط الجانبي"></div>

            <div class="char-count" id="char-count">0 حرف</div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-header">⚙️ النشر</div>
                <div class="sidebar-card-body">
                    <button class="btn-publish" type="submit" id="publish-btn">
                        <span id="publish-text">🚀 نشر المقال</span>
                    </button>
                    <button class="btn-draft" type="button">💾 حفظ كمسودة</button>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-card-header">📎 رفع ملف Word</div>
                <div class="sidebar-card-body">
                    <div class="upload-zone" id="drop-zone">
                        <input type="file" id="upload" accept=".docx">
                        <div class="icon">📄</div>
                        <p>اسحب ملف <strong>.docx</strong> أو انقر للتصفح</p>
                    </div>
                    <p id="file-name" style="font-size:.78rem;color:var(--muted);margin-top:.5rem;text-align:center"></p>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-card-header">🖼 صور المقال</div>
                <div class="sidebar-card-body">
                    <div class="upload-zone">
                        <input type="file" id="images-input" name="images[]" multiple accept="image/*">
                        <div class="icon">🗂</div>
                        <p>ارفع صور المقال هنا</p>
                    </div>
                    <div id="image-previews" style="display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.6rem"></div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://unpkg.com/mammoth/mammoth.browser.min.js"></script>
<script>
const editor = document.getElementById('output');
const charCount = document.getElementById('char-count');

// Format commands
function fmt(cmd) { document.execCommand(cmd, false, null); editor.focus(); }

function insertBlockquote() {
    const sel = window.getSelection();
    const text = sel.toString() || 'اكتب اقتباسك هنا...';
    document.execCommand('insertHTML', false, `<blockquote>${text}</blockquote><p><br></p>`);
    editor.focus();
}

function insertImage() {
    const url = prompt('أدخل رابط الصورة:');
    if (url) document.execCommand('insertHTML', false, `<img src="${url}" alt="صورة">`);
    editor.focus();
}

// Char counter
editor.addEventListener('input', () => {
    const len = editor.innerText.replace(/\s+/g,' ').trim().length;
    charCount.textContent = `${len.toLocaleString('ar')} حرف`;
});

// Form submit
document.getElementById('article-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const content = editor.innerHTML.trim();
    if (!content || content === '') { showToast('الرجاء كتابة محتوى المقال', 'error'); return; }
    document.getElementById('contentInput').value = content;
    const btn = document.getElementById('publish-btn');
    const txt = document.getElementById('publish-text');
    btn.disabled = true;
    txt.textContent = 'جارٍ النشر...';
    this.submit();
});

// Docx upload
document.getElementById('upload').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    document.getElementById('file-name').textContent = `📄 ${file.name}`;
    const reader = new FileReader();
    reader.onload = function (ev) {
        mammoth.convertToHtml({ arrayBuffer: ev.target.result })
            .then(result => { editor.innerHTML = result.value; showToast('تم تحميل الملف بنجاح ✓', 'success'); })
            .catch(err => { console.error(err); showToast('فشل تحميل الملف', 'error'); });
    };
    reader.readAsArrayBuffer(file);
});

// Image previews
document.getElementById('images-input').addEventListener('change', function () {
    const wrap = document.getElementById('image-previews');
    wrap.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const url = URL.createObjectURL(file);
        const img = document.createElement('img');
        img.src = url;
        img.style.cssText = 'width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid var(--card-border)';
        wrap.appendChild(img);
    });
});

// Drag and drop docx
const dropZone = document.getElementById('drop-zone');
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor = 'var(--accent)'; });
dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = ''; });
dropZone.addEventListener('drop', e => {
    e.preventDefault(); dropZone.style.borderColor = '';
    const file = e.dataTransfer.files[0];
    if (file && file.name.endsWith('.docx')) {
        document.getElementById('upload').files = e.dataTransfer.files;
        document.getElementById('upload').dispatchEvent(new Event('change'));
    }
});
</script>
@endpush