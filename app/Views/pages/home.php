<?php
// Define course order for professional menu layout
$courseOrder = ['Starters', 'Main Course', 'Rice', 'Breads', 'Desserts', 'Beverages', 'Sides'];

// Group items
$vegItems    = [];
$nonVegItems = [];
$otherItems  = [];
$otherCats   = ['Beverages', 'Sides', 'Desserts'];

if (!empty($items)) {
    foreach ($items as $row) {
        $cat = $row['categories'] ?? 'Uncategorized';
        if (in_array($cat, $otherCats)) {
            $otherItems[$cat][] = $row;
        } elseif (isset($row['veg']) && $row['veg'] === 'YES') {
            $vegItems[$cat][] = $row;
        } else {
            $nonVegItems[$cat][] = $row;
        }
    }
}

// Sort categories by course order
function sortCategories(&$groups, $order) {
    $sorted = [];
    foreach ($order as $cat) {
        if (isset($groups[$cat])) {
            $sorted[$cat] = $groups[$cat];
        }
    }
    foreach ($groups as $cat => $items) {
        if (!isset($sorted[$cat])) $sorted[$cat] = $items;
    }
    $groups = $sorted;
}
sortCategories($vegItems, $courseOrder);
sortCategories($nonVegItems, $courseOrder);
sortCategories($otherItems, $courseOrder);

function renderCards($categoryGroups, $tabId) {
    if (empty($categoryGroups)) {
        echo '<div class="empty-section"><span>🍽️</span><p>No items in this section yet.</p></div>';
        return;
    }
    foreach ($categoryGroups as $category => $categoryItems) {
        echo '<div class="cat-block" data-tab="' . $tabId . '">';
        echo '<div class="cat-label-row"><span class="cat-label">' . htmlspecialchars($category) . '</span><div class="cat-rule"></div></div>';
        echo '<div class="cards-grid">';
        foreach ($categoryItems as $row) {
            $id      = $row['item_id'];
            $img     = BASE_URL . '/public/img/' . (!empty($row['image']) ? $row['image'] : 'placeholder.png');
            $isVeg   = isset($row['veg']) && $row['veg'] === 'YES';
            $price   = number_format($row['price'], 0);
            $name    = htmlspecialchars($row['item_name']);
            $desc    = htmlspecialchars($row['item_desc'] ?? '');
            ?>
            <div class="dish-card" data-name="<?php echo strtolower($row['item_name']); ?>">
                <div class="dish-img-wrap">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" class="dish-img" loading="lazy">
                    <span class="type-dot <?php echo $isVeg ? 'dot-veg' : 'dot-nonveg'; ?>" title="<?php echo $isVeg ? 'Vegetarian' : 'Non-Vegetarian'; ?>"></span>
                </div>
                <div class="dish-info">
                    <div class="dish-top">
                        <h4 class="dish-name"><?php echo $name; ?></h4>
                        <?php if ($desc): ?>
                        <p class="dish-desc"><?php echo $desc; ?></p>
                        <?php endif; ?>
                    </div>
                    <form id="form<?php echo $id; ?>" onsubmit="event.preventDefault(); addToCart('<?php echo $id; ?>')" style="width: 100%;">
                        <div class="dish-bottom" style="flex-direction: column; align-items: stretch; gap: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="dish-price">₹<?php echo $price; ?></span>
                                <div class="dish-actions">
                                    <div class="qty-wrap">
                                        <button type="button" class="q-btn" onclick="changeQty('<?php echo $id; ?>',-1)">−</button>
                                        <span class="q-val" id="qval<?php echo $id; ?>">1</span>
                                        <input type="hidden" name="qty" id="qty<?php echo $id; ?>" value="1">
                                        <button type="button" class="q-btn" onclick="changeQty('<?php echo $id; ?>',1)">+</button>
                                    </div>
                                    <button type="submit" class="add-btn" id="addbtn<?php echo $id; ?>">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg>
                                        Add
                                    </button>
                                </div>
                            </div>
                            <input type="text" id="notes<?php echo $id; ?>" class="form-control" style="background: rgba(255,255,255,0.02); border-color: var(--border); font-size: 0.8rem; padding: 0.4rem 0.6rem; height: auto;" placeholder="Special instructions (e.g., less spicy, no onion)">
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
        echo '</div>'; // .cards-grid
        echo '</div>'; // .cat-block
    }
}
?>

<!-- ===== HERO BANNER ===== -->
<div class="menu-hero" style="position: relative; overflow: hidden; min-height: 65vh; display: flex; flex-direction: column; justify-content: center; background: #000;">
    <!-- Background Video -->
    <video autoplay muted loop playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; pointer-events: none; opacity: 0.75;">
        <source src="<?php echo BASE_URL; ?>/public/video/restro_demo.mp4" type="video/mp4">
    </video>
    <!-- Overlay to ensure text readability -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 100%); z-index: 1; pointer-events: none;"></div>

    <div class="menu-hero-content" style="position: relative; z-index: 2;">
        <div class="menu-hero-text">
            <p class="menu-tag">🍴 RESTAURANT MENU</p>
            <h1 class="menu-hero-title">Our Menu</h1>
            <p class="menu-hero-sub">Crafted with passion · Served with love</p>
        </div>
        <div class="search-wrap">
            <svg class="s-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" class="s-input" id="searchbox2" placeholder="Search dishes, categories…" oninput="doSearch()">
        </div>
    </div>
</div>

<!-- ===== TABS ===== -->
<div class="tab-bar">
    <button class="t-btn active" id="tab-btn-all"    onclick="showTab('all',   this)"><span>🍽️</span> All Items</button>
    <button class="t-btn"        id="tab-btn-veg"    onclick="showTab('veg',   this)"><span>🌿</span> Vegetarian</button>
    <button class="t-btn"        id="tab-btn-nonveg" onclick="showTab('nonveg',this)"><span>🍖</span> Non-Veg</button>
    <button class="t-btn"        id="tab-btn-other"  onclick="showTab('other', this)"><span>☕</span> Beverages & More</button>
</div>

<!-- ===== CONTENT ===== -->
<div class="menu-body" id="menuBody">

    <!-- ALL TAB -->
    <div class="tab-pane" id="pane-all">
        <div class="section-banner veg-banner"><span>🌿</span> Vegetarian</div>
        <?php renderCards($vegItems, 'all'); ?>
        <div class="section-banner nonveg-banner"><span>🍖</span> Non-Vegetarian</div>
        <?php renderCards($nonVegItems, 'all'); ?>
        <div class="section-banner other-banner"><span>☕</span> Beverages & More</div>
        <?php renderCards($otherItems, 'all'); ?>
    </div>

    <!-- VEG TAB -->
    <div class="tab-pane" id="pane-veg" style="display:none">
        <?php renderCards($vegItems, 'veg'); ?>
    </div>

    <!-- NON-VEG TAB -->
    <div class="tab-pane" id="pane-nonveg" style="display:none">
        <?php renderCards($nonVegItems, 'nonveg'); ?>
    </div>

    <!-- OTHER TAB -->
    <div class="tab-pane" id="pane-other" style="display:none">
        <?php renderCards($otherItems, 'other'); ?>
    </div>

</div>

<div id="no-results" class="no-results-wrap" style="display:none">
    <div class="nr-icon">🔍</div>
    <p>No dishes found for "<span id="nr-query"></span>"</p>
</div>

<script>
var activeTab = 'all';

function showTab(tab, el) {
    document.querySelectorAll('.t-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.tab-pane').forEach(p => p.style.display = 'none');
    document.getElementById('pane-' + tab).style.display = 'block';
    activeTab = tab;
    // Reset search
    document.getElementById('searchbox2').value = '';
    document.querySelectorAll('.dish-card').forEach(c => c.style.display = '');
    document.getElementById('no-results').style.display = 'none';
    // Reset cat-blocks
    document.querySelectorAll('.cat-block').forEach(b => b.style.display = '');
}

function doSearch() {
    var q = document.getElementById('searchbox2').value.toLowerCase().trim();
    var pane = document.getElementById('pane-' + activeTab);
    var cards = pane.querySelectorAll('.dish-card');
    var found = 0;
    cards.forEach(function(card) {
        var name = card.getAttribute('data-name') || '';
        var show = !q || name.includes(q);
        card.style.display = show ? '' : 'none';
        if (show) found++;
    });
    // Hide empty cat-blocks
    pane.querySelectorAll('.cat-block').forEach(function(block) {
        var visible = Array.from(block.querySelectorAll('.dish-card')).some(c => c.style.display !== 'none');
        block.style.display = visible ? '' : 'none';
    });
    var nr = document.getElementById('no-results');
    nr.style.display = (found === 0 && q) ? 'flex' : 'none';
    if (found === 0 && q) document.getElementById('nr-query').textContent = q;
}

function changeQty(id, d) {
    var inp = document.getElementById('qty' + id);
    var val = document.getElementById('qval' + id);
    var v = parseInt(inp.value) + d;
    if (v < 1) v = 1;
    if (v > 20) v = 20;
    inp.value = v;
    val.textContent = v;
}

function addToCart(id) {
    var qty = document.getElementById('qty' + id).value;
    var notes = document.getElementById('notes' + id) ? document.getElementById('notes' + id).value : '';
    var btn = document.getElementById('addbtn' + id);
    btn.disabled = true;
    btn.classList.add('btn-loading');
    btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/></svg> Adding…';
    $.ajax({
        url: "<?php echo BASE_URL; ?>/cart/add",
        method: "POST",
        dataType: "text",
        data: { ids: id, qty: qty, notes: notes },
        success: function(response) {
            btn.classList.remove('btn-loading');
            if (response.trim() === 'success') {
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20 6L9 17l-5-5"/></svg> Added!';
                btn.classList.add('btn-done');
                if(document.getElementById('notes' + id)) document.getElementById('notes' + id).value = '';
                setTimeout(function() {
                    btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg> Add';
                    btn.classList.remove('btn-done');
                    btn.disabled = false;
                }, 2000);
            } else {
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg> Add';
                btn.disabled = false;
                alert('Error: ' + response);
            }
        },
        error: function() {
            btn.classList.remove('btn-loading');
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg> Add';
            btn.disabled = false;
            alert('Connection error');
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var cartBtn = document.getElementById('viewcartbutton');
    if (cartBtn) cartBtn.style.display = 'block';
});
</script>
