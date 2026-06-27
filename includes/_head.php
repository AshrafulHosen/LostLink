<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LostLink — KUET Campus Lost & Found</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
/* ═══════════════════════════════════════════════
   RESET & ROOT
═══════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --navy:   #080F1A;
  --navy2:  #0D1826;
  --navy3:  #132030;
  --navy4:  #1A2A3E;
  --cyan:   #00C2E0;
  --cyan2:  #0099B8;
  --gold:   #F5A623;
  --gold2:  #D4891C;
  --green:  #22D07A;
  --red:    #F0524F;
  --purple: #9B72F5;
  --border: rgba(255,255,255,0.07);
  --border2:rgba(0,194,224,0.2);
  --txt:    #E8EFF8;
  --txt2:   #7A92A8;
  --txt3:   #4A6070;
  --glow:   0 0 30px rgba(0,194,224,0.12);
  --shadow: 0 4px 24px rgba(0,0,0,0.5);
}
html { scroll-behavior: smooth; }
body {
  font-family: 'Outfit', sans-serif;
  background: var(--navy);
  color: var(--txt);
  min-height: 100vh;
  overflow-x: hidden;
}

/* SCROLLBAR */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--navy2); }
::-webkit-scrollbar-thumb { background: var(--navy4); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: var(--cyan2); }

/* PAGES */
.page { display: none; min-height: 100vh; }
.page.active { display: flex; }

/* ═══════════════════════════════════════════════
   AUTH PAGE
═══════════════════════════════════════════════ */
#page-auth {
  flex-direction: column; align-items: center; justify-content: center;
  padding: 24px; background: var(--navy); position: relative; overflow: hidden;
}
.auth-bg { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
.auth-bg-circle { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.12; }
.auth-bg-circle.c1 { width: 500px; height: 500px; background: var(--cyan); top: -150px; left: -100px; }
.auth-bg-circle.c2 { width: 400px; height: 400px; background: var(--purple); bottom: -100px; right: -80px; }
.auth-bg-circle.c3 { width: 300px; height: 300px; background: var(--gold); top: 40%; left: 30%; }

.auth-logo { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; z-index: 1; }
.auth-logo-icon {
  width: 44px; height: 44px; background: var(--cyan); border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 0 20px rgba(0,194,224,0.4);
}
.auth-logo-icon i { font-size: 22px; color: var(--navy); }
.auth-logo-text { font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 800; color: var(--txt); }
.auth-logo-sub { font-size: 11px; color: var(--txt2); letter-spacing: 1.5px; text-transform: uppercase; }

.auth-card {
  background: var(--navy2); border: 1px solid var(--border);
  border-radius: 20px; padding: 36px 40px; width: 100%; max-width: 440px;
  position: relative; z-index: 1;
  box-shadow: 0 20px 60px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.05);
}
.auth-tabs {
  display: flex; gap: 4px; background: var(--navy); border-radius: 10px;
  padding: 4px; margin-bottom: 28px;
}
.auth-tab { flex: 1; text-align: center; padding: 9px; border-radius: 7px; font-size: 13px; font-weight: 500; cursor: pointer; color: var(--txt2); transition: all 0.2s; }
.auth-tab.active { background: var(--cyan); color: var(--navy); font-weight: 600; }

.auth-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 6px; }
.auth-sub { font-size: 13px; color: var(--txt2); margin-bottom: 24px; }

.form-row { margin-bottom: 16px; }
.form-label { font-size: 12px; font-weight: 500; color: var(--txt2); margin-bottom: 6px; display: block; letter-spacing: 0.3px; }
.form-input {
  width: 100%; padding: 11px 14px; border: 1px solid var(--border);
  border-radius: 10px; background: var(--navy); color: var(--txt);
  font-size: 14px; font-family: 'Outfit', sans-serif; outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input:focus { border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(0,194,224,0.1); }
.form-input::placeholder { color: var(--txt3); }
.input-icon-wrap { position: relative; }
.input-icon-wrap .form-input { padding-left: 40px; }
.input-icon-wrap .i-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--txt3); font-size: 16px; pointer-events: none; }

.btn-auth {
  width: 100%; padding: 12px; border-radius: 10px;
  background: var(--cyan); border: none; color: var(--navy);
  font-size: 14px; font-weight: 700; font-family: 'Outfit', sans-serif;
  cursor: pointer; margin-top: 8px; transition: all 0.2s; letter-spacing: 0.3px;
}
.btn-auth:hover { background: var(--cyan2); box-shadow: 0 4px 20px rgba(0,194,224,0.3); transform: translateY(-1px); }

.auth-divider { text-align: center; color: var(--txt3); font-size: 12px; margin: 20px 0; position: relative; }
.auth-divider::before, .auth-divider::after {
  content: ''; position: absolute; top: 50%; width: calc(50% - 30px); height: 1px; background: var(--border);
}
.auth-divider::before { left: 0; }
.auth-divider::after { right: 0; }

.auth-demo {
  background: rgba(0,194,224,0.06); border: 1px solid rgba(0,194,224,0.15);
  border-radius: 10px; padding: 12px 14px; font-size: 12px; color: var(--txt2);
  margin-top: 16px; line-height: 1.6;
}
.auth-demo strong { color: var(--cyan); }

/* ═══════════════════════════════════════════════
   MAIN APP LAYOUT
═══════════════════════════════════════════════ */
#page-app { flex-direction: row; }

/* SIDEBAR */
.sidebar { width: 230px; min-width: 230px; background: var(--navy2); border-right: 1px solid var(--border); display: flex; flex-direction: column; transition: width 0.25s; overflow: hidden; }
.sidebar-logo { padding: 20px 18px 16px; border-bottom: 1px solid var(--border); }
.logo-wrap { display: flex; align-items: center; gap: 10px; }
.logo-icon { width: 34px; height: 34px; background: var(--cyan); border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 0 14px rgba(0,194,224,0.35); }
.logo-icon i { font-size: 18px; color: var(--navy); }
.logo-txt { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 800; color: var(--txt); }
.logo-campus { font-size: 10px; color: var(--txt2); letter-spacing: 1px; text-transform: uppercase; }

.nav { padding: 14px 10px; flex: 1; overflow-y: auto; }
.nav-section { font-size: 10px; letter-spacing: 1.2px; text-transform: uppercase; color: var(--txt3); padding: 8px 8px 4px; margin-top: 4px; }
.nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 9px; cursor: pointer; font-size: 13px; font-weight: 400; color: var(--txt2); margin-bottom: 2px; transition: all 0.15s; position: relative; white-space: nowrap; }
.nav-item:hover { background: rgba(255,255,255,0.04); color: var(--txt); }
.nav-item.active { background: rgba(0,194,224,0.1); color: var(--cyan); font-weight: 500; }
.nav-item.active::before { content: ''; position: absolute; left: 0; top: 20%; height: 60%; width: 3px; background: var(--cyan); border-radius: 0 3px 3px 0; }
.nav-item i { font-size: 17px; flex-shrink: 0; }
.nav-badge { margin-left: auto; background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 8px; }
.nav-badge.blue { background: var(--cyan); }
.nav-badge.red  { background: var(--red); }

.sidebar-bottom { border-top: 1px solid var(--border); padding: 12px 10px; }
.user-pill { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 10px; cursor: pointer; transition: background 0.15s; }
.user-pill:hover { background: rgba(255,255,255,0.04); }
.avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--cyan); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: var(--navy); flex-shrink: 0; }
.user-name { font-size: 13px; font-weight: 500; color: var(--txt); line-height: 1.2; }
.user-role { font-size: 11px; color: var(--txt2); }
.logout-btn { margin-left: auto; color: var(--txt3); font-size: 16px; padding: 4px; border-radius: 5px; transition: color 0.15s; cursor: pointer; }
.logout-btn:hover { color: var(--red); }

/* MAIN CONTENT */
.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
.topbar { padding: 14px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 14px; background: var(--navy2); position: sticky; top: 0; z-index: 10; }
.topbar-title { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: var(--txt); flex: 1; }
.search-box { display: flex; align-items: center; gap: 9px; background: var(--navy); border: 1px solid var(--border); border-radius: 10px; padding: 8px 14px; max-width: 260px; width: 100%; transition: border-color 0.2s; }
.search-box:focus-within { border-color: var(--cyan2); }
.search-box i { font-size: 16px; color: var(--txt3); }
.search-box input { border: none; background: transparent; outline: none; font-size: 13px; color: var(--txt); width: 100%; font-family: 'Outfit', sans-serif; }
.search-box input::placeholder { color: var(--txt3); }
.topbar-notif { width: 36px; height: 36px; border-radius: 10px; background: var(--navy); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; transition: border-color 0.15s; }
.topbar-notif:hover { border-color: var(--cyan2); }
.topbar-notif i { font-size: 18px; color: var(--txt2); }
.notif-dot { position: absolute; top: 6px; right: 6px; width: 8px; height: 8px; border-radius: 50%; background: var(--red); border: 2px solid var(--navy2); }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 500; cursor: pointer; border: 1px solid var(--border); background: var(--navy3); color: var(--txt); font-family: 'Outfit', sans-serif; transition: all 0.15s; white-space: nowrap; }
.btn:hover { background: var(--navy4); border-color: rgba(255,255,255,0.12); }
.btn-primary { background: var(--cyan); border-color: var(--cyan); color: var(--navy); font-weight: 600; }
.btn-primary:hover { background: var(--cyan2); border-color: var(--cyan2); box-shadow: 0 4px 16px rgba(0,194,224,0.25); }
.btn-gold { background: var(--gold); border-color: var(--gold); color: var(--navy); font-weight: 600; }
.btn-gold:hover { background: var(--gold2); }
.btn-sm { padding: 5px 11px; font-size: 12px; border-radius: 7px; }
.btn-danger { background: rgba(240,82,79,0.1); border-color: rgba(240,82,79,0.3); color: var(--red); }
.btn-danger:hover { background: rgba(240,82,79,0.2); }
.btn-success { background: rgba(34,208,122,0.1); border-color: rgba(34,208,122,0.3); color: var(--green); }
.btn-success:hover { background: rgba(34,208,122,0.2); }

/* CONTENT & PANELS */
.content { flex: 1; overflow-y: auto; padding: 24px; }
.panel { display: none; animation: fadeIn 0.2s ease; }
.panel.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

/* COMMON COMPONENTS */
.stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
.stat-card { background: var(--navy2); border: 1px solid var(--border); border-radius: 14px; padding: 18px; position: relative; overflow: hidden; transition: border-color 0.2s; }
.stat-card:hover { border-color: rgba(255,255,255,0.12); }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
.stat-card.cyan::before  { background: var(--cyan); }
.stat-card.green::before { background: var(--green); }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.red::before   { background: var(--red); }
.stat-card.purple::before{ background: var(--purple); }
.stat-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
.stat-icon.cyan   { background: rgba(0,194,224,0.12); color: var(--cyan); }
.stat-icon.green  { background: rgba(34,208,122,0.12); color: var(--green); }
.stat-icon.gold   { background: rgba(245,166,35,0.12); color: var(--gold); }
.stat-icon.red    { background: rgba(240,82,79,0.12); color: var(--red); }
.stat-icon.purple { background: rgba(155,114,245,0.12); color: var(--purple); }
.stat-icon i { font-size: 20px; }
.stat-num { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: var(--txt); line-height: 1; }
.stat-label { font-size: 12px; color: var(--txt2); margin-top: 5px; }
.stat-delta { font-size: 11px; margin-top: 8px; }
.stat-delta.up { color: var(--green); }
.stat-delta.down { color: var(--red); }

.section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.section-title { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--txt); }

.badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 20px; }
.badge-lost     { background: rgba(240,82,79,0.1);   color: #F27472; border: 1px solid rgba(240,82,79,0.2); }
.badge-found    { background: rgba(34,208,122,0.1);  color: #22D07A; border: 1px solid rgba(34,208,122,0.2); }
.badge-matched  { background: rgba(245,166,35,0.1);  color: var(--gold); border: 1px solid rgba(245,166,35,0.2); }
.badge-active   { background: rgba(0,194,224,0.1);   color: var(--cyan); border: 1px solid rgba(0,194,224,0.2); }
.badge-pending  { background: rgba(245,166,35,0.08); color: var(--gold); border: 1px solid rgba(245,166,35,0.15); }
.badge-approved { background: rgba(34,208,122,0.1);  color: var(--green); border: 1px solid rgba(34,208,122,0.2); }
.badge-rejected { background: rgba(240,82,79,0.1);   color: var(--red); border: 1px solid rgba(240,82,79,0.2); }
.badge-claimed  { background: rgba(155,114,245,0.1); color: var(--purple); border: 1px solid rgba(155,114,245,0.2); }
.badge-returned { background: rgba(34,208,122,0.1);  color: var(--green); border: 1px solid rgba(34,208,122,0.2); }
.badge-recovered{ background: rgba(34,208,122,0.1);  color: var(--green); border: 1px solid rgba(34,208,122,0.2); }

.filter-row { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
.chip { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 500; cursor: pointer; border: 1px solid var(--border); color: var(--txt2); transition: all 0.15s; }
.chip:hover { border-color: rgba(0,194,224,0.3); color: var(--txt); }
.chip.active { background: rgba(0,194,224,0.1); border-color: var(--cyan); color: var(--cyan); }

/* TABLE */
.table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid var(--border); }
table { width: 100%; border-collapse: collapse; font-size: 13px; }
thead tr { border-bottom: 1px solid var(--border); }
th { padding: 11px 14px; text-align: left; font-size: 11px; font-weight: 600; color: var(--txt2); letter-spacing: 0.5px; text-transform: uppercase; white-space: nowrap; }
td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--txt); vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr { transition: background 0.1s; }
tbody tr:hover td { background: rgba(255,255,255,0.02); }
.td-main { font-weight: 500; }
.td-sub { font-size: 11px; color: var(--txt2); margin-top: 2px; }

/* CARDS */
.card { background: var(--navy2); border: 1px solid var(--border); border-radius: 14px; padding: 18px; }
.items-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 12px; }
.item-card { background: var(--navy2); border: 1px solid var(--border); border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.2s; position: relative; }
.item-card:hover { border-color: rgba(0,194,224,0.3); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
.item-card.has-match { border-left: 3px solid var(--gold); }
.item-card.is-found  { border-left: 3px solid var(--green); }
.item-top { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px; }
.item-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.item-icon.lost  { background: rgba(240,82,79,0.12); color: var(--red); }
.item-icon.found { background: rgba(34,208,122,0.12); color: var(--green); }
.item-icon i { font-size: 19px; }
.item-name { font-size: 13px; font-weight: 500; color: var(--txt); line-height: 1.3; }
.item-loc  { font-size: 11px; color: var(--txt2); margin-top: 3px; display: flex; align-items: center; gap: 4px; }
.item-loc i { font-size: 12px; }
.item-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border); }
.item-date { font-size: 11px; color: var(--txt3); }

/* PROGRESS */
.progress { height: 4px; background: var(--navy); border-radius: 2px; overflow: hidden; flex: 1; max-width: 80px; }
.progress-bar { height: 100%; border-radius: 2px; background: var(--cyan); transition: width 0.4s ease; }

/* MATCH CARD */
.match-card { background: var(--navy2); border: 1px solid rgba(245,166,35,0.2); border-radius: 14px; padding: 18px; margin-bottom: 12px; transition: border-color 0.2s; }
.match-card:hover { border-color: rgba(245,166,35,0.4); }
.match-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.match-score-badge { display: flex; align-items: center; gap: 6px; background: rgba(245,166,35,0.1); border: 1px solid rgba(245,166,35,0.2); border-radius: 20px; padding: 5px 12px; font-size: 13px; font-weight: 700; color: var(--gold); }
.match-body { display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px; align-items: center; }
.match-item { background: var(--navy3); border-radius: 10px; padding: 12px; }
.match-item-label { font-size: 10px; letter-spacing: 1px; text-transform: uppercase; color: var(--txt3); margin-bottom: 6px; }
.match-item-name { font-size: 13px; font-weight: 500; color: var(--txt); }
.match-item-loc  { font-size: 11px; color: var(--txt2); margin-top: 3px; }
.match-arrow { color: var(--txt3); font-size: 22px; }
.match-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--border); }
.match-reporters { font-size: 11px; color: var(--txt3); }

/* ALERT BANNER */
.alert-banner { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; }
.alert-banner.gold  { background: rgba(245,166,35,0.07); border: 1px solid rgba(245,166,35,0.2); color: var(--txt); }
.alert-banner.cyan  { background: rgba(0,194,224,0.07);  border: 1px solid rgba(0,194,224,0.2);  color: var(--txt); }
.alert-banner.green { background: rgba(34,208,122,0.07); border: 1px solid rgba(34,208,122,0.2); color: var(--txt); }
.alert-banner i { font-size: 20px; flex-shrink: 0; }
.alert-banner.gold i  { color: var(--gold); }
.alert-banner.cyan i  { color: var(--cyan); }
.alert-banner.green i { color: var(--green); }
.alert-link { margin-left: auto; font-size: 12px; color: var(--cyan); cursor: pointer; white-space: nowrap; }
.alert-link:hover { text-decoration: underline; }

/* FORM */
.form-card { background: var(--navy2); border: 1px solid var(--border); border-radius: 14px; padding: 24px; }
.form-section-title { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: var(--txt2); letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid var(--border); }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-field { display: flex; flex-direction: column; gap: 6px; }
.form-field.full { grid-column: span 2; }
.form-label { font-size: 12px; font-weight: 500; color: var(--txt2); }
.form-input-app { padding: 10px 13px; border: 1px solid var(--border); border-radius: 10px; background: var(--navy); color: var(--txt); font-size: 13px; font-family: 'Outfit', sans-serif; outline: none; transition: border-color 0.2s; }
.form-input-app:focus { border-color: var(--cyan); box-shadow: 0 0 0 3px rgba(0,194,224,0.08); }
.form-input-app::placeholder { color: var(--txt3); }
select.form-input-app { cursor: pointer; }
select.form-input-app option { background: var(--navy2); }
textarea.form-input-app { resize: vertical; min-height: 90px; }
.form-hint { font-size: 11px; color: var(--txt3); margin-top: 2px; }
.form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--border); }
.form-tab-row { display: flex; gap: 6px; margin-bottom: 20px; }
.form-tab { padding: 9px 20px; border-radius: 9px; font-size: 13px; font-weight: 500; cursor: pointer; border: 1px solid var(--border); color: var(--txt2); transition: all 0.2s; }
.form-tab.active { background: var(--cyan); border-color: var(--cyan); color: var(--navy); font-weight: 600; }

.success-toast { display: none; align-items: center; gap: 12px; background: rgba(34,208,122,0.08); border: 1px solid rgba(34,208,122,0.2); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; }
.success-toast.show { display: flex; }
.success-toast i { font-size: 22px; color: var(--green); }
.success-toast strong { color: var(--green); }

/* NOTIFICATIONS */
.notif-list { display: flex; flex-direction: column; }
.notif-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--border); }
.notif-item:last-child { border-bottom: none; }
.notif-icon { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.notif-icon.match { background: rgba(245,166,35,0.12); color: var(--gold); }
.notif-icon.claim { background: rgba(34,208,122,0.12); color: var(--green); }
.notif-icon.info  { background: rgba(0,194,224,0.12);  color: var(--cyan); }
.notif-icon i { font-size: 18px; }
.notif-text { font-size: 13px; color: var(--txt); line-height: 1.5; flex: 1; }
.notif-time { font-size: 11px; color: var(--txt3); margin-top: 3px; }
.notif-unread { width: 7px; height: 7px; border-radius: 50%; background: var(--cyan); margin-top: 6px; flex-shrink: 0; }

/* ANALYTICS */
.analytics-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 20px; }
.chart-card { background: var(--navy2); border: 1px solid var(--border); border-radius: 14px; padding: 20px; }
.chart-title { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: var(--txt); margin-bottom: 18px; }
.bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.bar-label { font-size: 12px; color: var(--txt2); width: 90px; flex-shrink: 0; text-align: right; }
.bar-track { flex: 1; height: 8px; background: var(--navy); border-radius: 4px; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 4px; transition: width 0.8s ease; }
.bar-val { font-size: 12px; color: var(--txt2); width: 28px; text-align: right; }
.hotspot-item { display: flex; align-items: center; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--border); }
.hotspot-item:last-child { border-bottom: none; }
.hotspot-rank { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: var(--border); width: 28px; }
.hotspot-name { font-size: 13px; color: var(--txt); flex: 1; }
.hotspot-count { font-size: 12px; color: var(--txt2); }
.recovery-arc { text-align: center; padding: 10px 0; }
.arc-num { font-family: 'Syne', sans-serif; font-size: 48px; font-weight: 800; color: var(--cyan); }
.arc-label { font-size: 13px; color: var(--txt2); }

/* ADMIN */
.claim-row td { vertical-align: middle; }
.proof-tags span { display: inline-block; background: var(--navy3); border: 1px solid var(--border); border-radius: 5px; padding: 2px 8px; font-size: 11px; color: var(--txt2); margin-right: 4px; }

/* MODAL */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; padding: 24px; backdrop-filter: blur(4px); }
.modal-overlay.open { display: flex; }
.modal { background: var(--navy2); border: 1px solid var(--border); border-radius: 18px; width: 100%; max-width: 520px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.7); animation: modalIn 0.2s ease; }
@keyframes modalIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid var(--border); }
.modal-title { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; }
.modal-close { color: var(--txt3); cursor: pointer; font-size: 20px; transition: color 0.15s; }
.modal-close:hover { color: var(--red); }
.modal-body { padding: 24px; }
.modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; }

/* DETAIL ROWS */
.detail-row { display: flex; gap: 8px; margin-bottom: 12px; font-size: 13px; }
.detail-key { color: var(--txt2); width: 110px; flex-shrink: 0; }
.detail-val { color: var(--txt); font-weight: 500; }

/* TAG */
.tag { display: inline-flex; align-items: center; gap: 4px; background: var(--navy3); border: 1px solid var(--border); border-radius: 6px; padding: 3px 9px; font-size: 11px; color: var(--txt2); }

/* PROFILE */
.profile-header { display: flex; align-items: center; gap: 20px; padding: 24px; background: var(--navy2); border: 1px solid var(--border); border-radius: 14px; margin-bottom: 20px; }
.profile-avatar { width: 72px; height: 72px; border-radius: 50%; background: var(--cyan); display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: var(--navy); flex-shrink: 0; }
.profile-name { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; }
.profile-email { font-size: 13px; color: var(--txt2); margin-top: 4px; }
.profile-badges { display: flex; gap: 8px; margin-top: 10px; }
.profile-stat-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
.profile-stat { background: var(--navy2); border: 1px solid var(--border); border-radius: 12px; padding: 16px; text-align: center; }
.profile-stat-num { font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 800; color: var(--cyan); }
.profile-stat-label { font-size: 12px; color: var(--txt2); margin-top: 4px; }

/* RESPONSIVE */
@media (max-width: 900px) {
  .stats-grid { grid-template-columns: repeat(2,1fr); }
  .items-grid  { grid-template-columns: 1fr; }
  .analytics-grid { grid-template-columns: 1fr; }
  .form-grid   { grid-template-columns: 1fr; }
  .form-field.full { grid-column: span 1; }
  .match-body  { grid-template-columns: 1fr; }
  .match-arrow { display: none; }
}
@media (max-width: 700px) {
  .sidebar { display: none; }
}
</style>
</head>
<body>
