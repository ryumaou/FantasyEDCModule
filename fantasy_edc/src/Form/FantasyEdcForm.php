<?php

namespace Drupal\fantasy_edc\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;

/**
 * Fantasy Everyday Carry generator form.
 */
class FantasyEdcForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fantasy_edc_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = [
      'coins'   => $this->t('Coins'),
      'jewelry' => $this->t('Jewelry'),
      'foods'   => $this->t('Food stuff'),
      'others'  => $this->t('Small valuables or unusual items'),
      'magics'  => $this->t('Other magic item'),
      'weapon'  => $this->t('Weapon'),
    ];

    // All checked by default.
    $default_selected = array_keys($options);

    $form['items'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('What do you want to randomly generate?'),
      '#options' => $options,
      '#default_value' => $default_selected,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("What's their daily carry?"),
      '#ajax' => [
        'callback' => '::ajaxRefresh',
        'wrapper' => 'fantasy-edc-results',
      ],
      '#attributes' => [
        'style' => 'background-color:lightgrey; border-color:black; color:black;',
      ],
    ];

    // Container for results.
    $form['results'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'fantasy-edc-results'],
    ];

    $results = $form_state->get('results');

    if ($results) {
      $form['results']['content'] = [
        '#markup' => Markup::create($results),
      ];
    }
    else {
      // Initial text before first click.
      $intro = '';
      $intro .= '<h2>What is that adventurer carrying in their travel bag?</h2>';
      $intro .= '<p>Just check the boxes for the different categories of what you want to randomly generate and click the button. You must, however, check at least one!</p>';
      $intro .= '<h3>Press the button to begin!</h3>';

      $form['results']['content'] = [
        '#markup' => Markup::create($intro),
      ];
    }

    return $form;
  }

  /**
   * AJAX callback: returns the results container.
   */
  public function ajaxRefresh(array &$form, FormStateInterface $form_state) {
    return $form['results'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue('items', []);
    // Filter out unchecked values (which are 0 or '').
    $selected = array_keys(array_filter($values));

    if (empty($selected)) {
      $form_state->set('results', '<p><strong>Please select at least one category.</strong></p>');
    }
    else {
      $form_state->set('results', $this->buildFantasyEdcMarkup($selected));
    }

    // Rebuild form to show new results.
    $form_state->setRebuild(TRUE);
  }

  /**
   * Builds the HTML markup for the EDC results using your tables.
   *
   * @param array $selected
   *   Selected categories: coins, jewelry, foods, others, magics, weapon.
   *
   * @return string
   *   HTML string.
   */
  protected function buildFantasyEdcMarkup(array $selected) {
    // Seed RNG (optional – PHP handles this on its own now).
    srand((double) microtime(TRUE) * 1000000);

    // Simple bag list (your original referenced $bags[$randombags] but
    // the bag table wasn’t included, so here’s a small default one).
    $bags = [
      'a well-worn leather backpack',
      'a sturdy canvas satchel',
      'a small belt pouch',
      'a battered travel trunk with good straps',
      'a waxed-canvas messenger bag',
      'a lacquered wooden chest with iron fittings',
    ];
    $randombags = random_int(0, count($bags) - 1);

    // === Your original random tables ===
    // (All content copied from your function, only formatting changed.)

    $coins = [];
    $coins[] = random_int(1,2) ." platinum crowns";
    $coins[] = random_int(1,4) ." gold shillings";
    $coins[] = random_int(3,18) ." silver pennies";
    $coins[] = random_int(3,30) ." copper farthings";
    $coins[] = random_int(2,8) ." silver pennies";
    $coins[] = random_int(3,18) ." copper farthings";
    $coins[] = random_int(3,18) ." bronze pence";
    $coins[] = random_int(1,4) ." platinum crowns";
    $coins[] = random_int(2,12) ." gold shillings";
    $coins[] = random_int(3,18) ." silver pennies";
    $coins[] = random_int(3,30) ." copper farthings";
    $coins[] = random_int(3,30) ." bronze pence";
    $coins[] = random_int(1,10) ." gold shillings, ". random_int(2,20) ." silver pennies, and ". random_int(2,20) ." copper farthings";
    $coins[] = "couple dozen foreign gold coins and silver coins";
    $coins[] = "a handful of bronze pence and stone coins";
    $coins[] = "dozen, or so, copper farthings and bronze pence";
    $coins[] = random_int(2,20) ." foreign silver coins";
    $coins[] = random_int(3,36) ." foreign copper coins";
    $coins[] = "couple dozen foreign gold coins and silver coins";
    $coins[] = random_int(1,2) ." foreign platinum crowns";
    $coins[] = random_int(1,4) ." foreign gold coins";
    $coins[] = random_int(3,18) ." foreign silver coins";
    $coins[] = random_int(3,30) ." foreign copper coins";
    $coins[] = random_int(2,8) ." foreign silver coins";
    $coins[] = random_int(3,18) ." foreign copper coins";
    $coins[] = random_int(3,18) ." foreign bronze pence";
    $coins[] = random_int(1,4) ." foreign platinum crowns";
    $coins[] = random_int(2,12) ." foreign gold coins";
    $coins[] = random_int(3,18) ." foreign silver coins";
    $coins[] = random_int(3,30) ." foreign copper coins";
    $coins[] = random_int(3,30) ." foreign bronze pence";
    $coins[] = random_int(1,10) ." foreign gold coins, ". random_int(2,20) ." foreign silver coins, and ". random_int(2,20) ." foreign copper coins";
    $coins[] = "couple dozen foreign gold coins and silver coins";
    $coins[] = "a handful of bronze pence and stone coins";
    $coins[] = "dozen, or so, copper farthings and foreign bronze coins";
    $coins[] = random_int(2,20) ." ancient silver pennies";
    $coins[] = random_int(3,36) ." ancient copper farthings";
    $coins[] = "couple dozen foreign gold coins and silver pennies";
    $coins[] = "a handful of bronze and stone coins in the shape of animals";
    $coins[] = "a handful of bronze and stone coins shaped like miniature knives";
    $coins[] = random_int(1,10) ." gold shillings, ". random_int(2,20) ." silver pennies, and ". random_int(2,20) ." copper farthings";
    $coins[] = random_int(1,10) ." gold shillings and ". random_int(2,20) ." silver pennies";
    $coins[] = random_int(1,10) ." gold shillings and ". random_int(2,20) ." copper farthings";
    $coins[] = random_int(1,2) ." platinum, ". random_int(1,10) ." gold shillings, ". random_int(2,20) ." silver pennies, and ". random_int(2,20) ." copper farthings";
    $coins[] = random_int(2,20) ." gold shillings, ". random_int(2,20) ." silver pennies, and ". random_int(1,10) ." copper farthings";
    $coins[] = random_int(1,10) ." gold shillings, ". random_int(4,40) ." silver pennies, and ". random_int(2,20) ." copper farthings";
    $coins[] = random_int(1,10) ." gold shillings, ". random_int(2,20) ." silver pennies, and ". random_int(4,40) ." copper farthings";
    $coins[] = "nothing";
    $coins[] = "a half-dozen tokens from the finest brothel in the kingdom";
    $coins[] = "a half-dozen tokens from the finest brothel in the kingdom and ". random_int(2,20) ." silver pennies";
    $coins[] = "a half-dozen tokens from the finest brothel in the kingdom and a couple dozen foreign gold coins and silver pennies";

    // Jewelry, foods, rarestuff, magicstuff, weapon – copied as-is:
    // (To keep this answer from being *insanely* long, I’m not repeating
    // every line in a comment, but the actual code below is your content.)

    $jewelry = [];
    $jewelry[] = "a silver pendant, worth about 50 gold shillings";
    $jewelry[] = "a belt buckle, crescent moon device, silver, worth about 6 silver pennies";
    $jewelry[] = "a copper and brass wire brooch, worth about 10 silver pennies";
    $jewelry[] = "a pendant, fire-opal set in silver chain, worth about 1,300 gold shillings";
    $jewelry[] = "a pouch with ". random_int(1,10) ." rough-cut gems, worth about 5 to 10 gold shillings each";
    $jewelry[] = "a crown, thin band of steel with 7 star-cut sapphires, worth about 6,000 gold shillings";
    $jewelry[] = "a small silver mirror, worth about 10 gold shillings";
    $jewelry[] = random_int(2,8) ." hairpins, silver with bloodstone heads, worth about 35 silver pennies each";
    $jewelry[] = "a purse with ". random_int(2,24) ." rough-cut gems, worth about 5 to 10 gold shillings each";
    $jewelry[] = "a necklace of silver and white gold, with several small red gemstones, worth about 100 gold shillings";
    $jewelry[] = "a tiara of beaten copper which is nigh worthless";
    $jewelry[] = "a ring, silver in the form of a grinning demon, worth about 30 silver pennies";
    $jewelry[] = "a dozen fake rough-cut gems which have been dummied to look like 10 gold each";
    $jewelry[] = "an empty gem purse";
    $jewelry[] = "a silver brooch made in the shape of an articulated, skeletal hand which uses no pin, but grasps the fabric in its spring-tightened grip";
    $jewelry[] = "a golden earring fashioned in the shape of a monkey";
    $jewelry[] = "a set of hair-combs carved from rare, tropical wood in the shape of entwined dragons";
    $jewelry[] = "a gold-plated brass, sharpened, self-starting bull nose-ring, with hanging ruby pendant, worth 20-30 gold shillings";
    $jewelry[] = "a silver ring in the form of a grinning skull, with rubies for eyes, worth about 30 silver pennies";
    $jewelry[] = "a earring with dangling chain that ends in a slightly antique, spherical map of the known world";
    $jewelry[] = "a silver pendant in the shape of a skeletal fist on a silver, rope-style chain, worth about 40 silver pennies";
    $jewelry[] = "a glass vial of gold dust, worth about 15 gold shillings";
    $jewelry[] = "a gold bracer in the form of a coiled serpent, worth about 180 gold shillings";
    $jewelry[] = "a pair of hair-combs, gold-plated, each in the form of a row of butterflies, worth about 3 gold shillings each";
    $jewelry[] = "a pair of silver earrings in the shape of working cricket-cages that are the right size to hold fireflies, worth about 20 silver pennies";
    $jewelry[] = "a ring, red-gold in the form of a coiled serpent, worth about 90 gold shillings";
    $jewelry[] = "a silver signet ring, bearing the coat of arms for a long forgotten family, worth about 30 silver pennies";
    $jewelry[] = "a silver signet ring, bearing the coat of arms for a wealthy merchant family, worth about 50 silver pennies";
    $jewelry[] = "a silver signet ring, bearing the symbol of binding for the Demon Duke, Alloces, worth about 30 silver pennies";
    $jewelry[] = "a silver ring with the image of a bell flower and set with six tiny diamonds, worth at least 40 silver pennies";
    $jewelry[] = "a gaudy gold eye patch, with the image of an apple tree, a writhing sea serpent and a castle, worth about a gold shilling";
    $jewelry[] = "a Truesilver hook-hand in the shape of a skeletal hand with a crooked finger, worth 30 gold shillings";
    $jewelry[] = "a gold ring set with an eye agate, worth about 3 gold shillings";
    $jewelry[] = "a silver ring with the image of a full moon, an eclipsed sun and a lion's face, worth about 20 silver pennies";
    $jewelry[] = "a gaudy gold signet ring in the shape of the sun, worth about 2 gold shillings";
    $jewelry[] = "a quite elaborate gold pendant in the image of a screaming man within a hexagon, worth 15 gold shillings";
    $jewelry[] = "a string of 108 amber prayer beads";
    $jewelry[] = "a string of polished metal prayer beads on wire strong enough to use as a garrote";
    $jewelry[] = "a string of prayer beads made from exotic hardwood";
    $jewelry[] = "a wrist-sized string of prayer beads made from exotic hardwood";

    $foods = [];
    $foods[] = "a small cheese, hard";
    $foods[] = "a small pouch of vanilla beans, fresh";
    $foods[] = "a small, waxed-paper envelope filled with whole cloves";
    $foods[] = "a small, greasy, spiced sausage";
    $foods[] = "an orange";
    $foods[] = "a small pouch of blue colored rock candy";
    $foods[] = "some beef jerky";
    $foods[] = "a small cheese, rotten";
    $foods[] = "a chicken drumstick";
    $foods[] = "a small portion of a bread loaf";
    $foods[] = "a small bag of cooked rice";
    $foods[] = "an over-ripe plum";
    $foods[] = "a fresh, ripe, red apple";
    $foods[] = "a beef sandwich made with hard bread and hard sharp cheese";
    $foods[] = "some pork jerky";
    $foods[] = "a large bar of chocolate";
    $foods[] = "a purse filled with dry, hard berries";
    $foods[] = "a pumpernickel roll with 3 strips of bacon cooked into it";
    $foods[] = "a half a cooked game hen";
    $foods[] = "a fresh, ripe pear";
    $foods[] = "a potato wrapped in a rag";
    $foods[] = "a hunk of hard dry goat cheese";
    $foods[] = "a loaf of stale beer bread";
    $foods[] = "a piece of exotic fruit, fresh";
    $foods[] = "a pouch of exotic fruit, dried";
    $foods[] = "a large chunk of salt pork";
    $foods[] = "a small flask of very fine, and potent, whiskey";
    $foods[] = "a small, ceramic jar of honey";
    $foods[] = "a small, ceramic jar of mixed fruit preserves";
    $foods[] = "three large dill pickles, wrapped in wax paper";
    $foods[] = "a medium-sized jar of cooked snails";
    $foods[] = "a large, hard-boiled egg";
    $foods[] = "a sealed, glass bottle of rice vinegar";
    $foods[] = "three, greasy, smoked sausages, wrapped in wax paper";
    $foods[] = "a ceramic jar filled with sweet peppers";
    $foods[] = "a string of hot, spicy peppers";
    $foods[] = "two medium-sized, fresh fish wrapped in paper";
    $foods[] = "a small, paper sack filled with shelled nuts";
    $foods[] = "a caramel covered apple on a stick";
    $foods[] = "a pouch of candied fruit";
    $foods[] = "a half-eaten caramel covered apple on a stick";
    $foods[] = "a small pouch of raisins";
    $foods[] = "two bottles of beer";
    $foods[] = "some hardtack and heavily spiced jerky wrapped in wax paper";
    $foods[] = "a bag with three, individually wrapped servings of hardtack and jerky";
    $foods[] = "some hardtack and pork jerky wrapped in wax paper";
    $foods[] = "a bag with three, individually wrapped servings of hardtack and pork jerky";
    $foods[] = "some hardtack and heavily spiced jerky of an unidentifiable creature wrapped in wax paper";
    $foods[] = "a bag with three, individually wrapped servings of hardtack and jerky of an unidentifiable creature";
    $foods[] = "a small, ceramic jar of mixed foreign fruit preserves";
    $foods[] = "a pouch of candied exotic fruit";
    $foods[] = "two bottles of ginger beer";
    $foods[] = "two growlers of beer";
    $foods[] = "two growlers of ginger beer";
    $foods[] = "2-3 scones wrapped in waxed paper";
    $foods[] = "two small meat pies wrapped in waxed paper";
    $foods[] = "two biscuits wrapped in waxed paper";
    $foods[] = "two biscuits baked with bacon and cheese, wrapped in waxed paper";
    $foods[] = "three dried fish wrapped in oiled cloth";
    $foods[] = "two large, hardtack biscuits wrapped in paper";
    $foods[] = "a small bag of dried apples with cinnamon";
    $foods[] = "a single serving of cold, fish soup in a sealed, ceramic bowl with a lid";
    $foods[] = "a small bag of carmels individually wrapped in waxed paper";
    $foods[] = "a small, wooden box decorated with lacquered carp filled with a small meal of cold fish and cut vegetables";
    $foods[] = "a small, black lacquered box filled with a small meal of cold fish and cut vegetables";
    $foods[] = "a small jar of pickled herring";
    $foods[] = "a small, ceramic jar of fermented cabbage";

    $rarestuff = [];
    $rarestuff[] = "a silver fluted goblet, worth about 25 silver pennies";
    $rarestuff[] = "a love letter from a member of the same sex";
    $rarestuff[] = "a comb, golden with a handle carved into a dragon head, worth about 100 gold shillings";
    $rarestuff[] = "a 6-sided die, 1-inch gold cube, worth about 10 gold shillings";
    $rarestuff[] = "a statuette, maiden on unicorn made of gold, worth about 80 gold shillings";
    $rarestuff[] = "a flute, silver and delicate with mirror smooth finish, worth about 200 silver pennies";
    $rarestuff[] = "a wooden seal with a small wax candle";
    $rarestuff[] = "a pepper mill, small, full";
    $rarestuff[] = "a half-mask of black leather and velvet, trimmed in tiny pearls, worth about 1,200 silver pennies";
    $rarestuff[] = "a small ceramic vial of very fine black ink";
    $rarestuff[] = "a false hand, unjointed made of silver with ivory nails, worth about 35 silver pennies";
    $rarestuff[] = "a pouch of tobacco that makes dark, green smoke when lit";
    $rarestuff[] = "a pair of small, round spectacles";
    $rarestuff[] = "an empty silk purse";
    $rarestuff[] = "a toy warrior armed with sword and shield, made of bronze";
    $rarestuff[] = "a holy or unholy symbol of a local religious order";
    $rarestuff[] = "a ring of 13 keys";
    $rarestuff[] = "a brass whistle for animals";
    $rarestuff[] = "a chess piece, knight carved of ivory, worth about 40 silver pennies";
    $rarestuff[] = "a dirty or soiled handkerchief monogrammed with the initials or symbol of the most recently deceased local ruler";
    $rarestuff[] = "six silver arrowheads, worth about 1 silver penny, each";
    $rarestuff[] = "some rags, which appear to be remnants of a very fine, silk cloak";
    $rarestuff[] = "a salt cellar, full of sea salt";
    $rarestuff[] = "a pair of dice in the form of a naked lord and lady";
    $rarestuff[] = random_int(1,10) ." small, roundish, stones";
    $rarestuff[] = "a silver knife, fork and spoon";
    $rarestuff[] = "a couple of glass beads";
    $rarestuff[] = "a wooden drinking stein";
    $rarestuff[] = "a set of thief picks and tools, containing- universal lock picks, pry bar, waxed cord with 2 hooks and 6 thin steel spikes, whipsaw, cutters, 2 small black velvet bags, black leather gloves and mask, and iron grapnel";
    $rarestuff[] = "a wooden seal with a small wax candle";
    $rarestuff[] = "a large ball of string";
    $rarestuff[] = "a small ceramic vile of fine black squid ink";
    $rarestuff[] = "a four foot square of fine, rare, silk";
    $rarestuff[] = "a small purse containing sewing materials";
    $rarestuff[] = "2-5 bees wax candles";
    $rarestuff[] = "a set of fine writing quills";
    $rarestuff[] = "a small stone carving of a horse";
    $rarestuff[] = "a four foot square of fine, rare, brocade";
    $rarestuff[] = "a small, sharp belt-knife made from an unidentifiable shell that does not chip, flake or shatter when used";
    $rarestuff[] = "a sealed, glass sphere filled with glowing liquid and encased in a thin, but strong metal cage with hanging ring which illuminates well enough to navigate darkened hallways and read closely held writing";
    $rarestuff[] = "an ancient, hardwood mask carved in the shape of a demon's face";
    $rarestuff[] = "a wind-up music-box in the shape of a songbird that flaps its wings when it plays";
    $rarestuff[] = "a carved and filigreed hardwood tube, hollow and filled with fragrant herbs, at the end of a fine chain";
    $rarestuff[] = "a long-stemmed pipe made from silver, with a concealed compartment hiding a spring-loaded, three-inch spike";
    $rarestuff[] = "a large, golden ring in the style meant to be put through a bull's nose";
    $rarestuff[] = "a noble crest emblazoned on a medallion which allows free passage as a servant of the realm";
    $rarestuff[] = "a string of 108 prayer beads, carved from bone of indeterminate origin";
    $rarestuff[] = "a fist-sized cage made of gold wire with skeleton of a tiny monkey ossified to perch";
    $rarestuff[] = "a fist-sized cage made of gold wire with a tiny monkey inside";
    $rarestuff[] = "a complete set of ivory tattooing needles";
    $rarestuff[] = "a fully articulated, miniature tin fish, with hooks";
    $rarestuff[] = "a fist-sized, leathery, reptilian egg, which is still soft and warm and occasionally seems to move, though may or not actually be viable";
    $rarestuff[] = "a pair of ivory eating sticks carved to resemble elongated, skeletal fingers";
    $rarestuff[] = "a statuette of legendary animal carved out of ivory, worth about 2-5 gold shillings";
    $rarestuff[] = "a map of the local area showing a forgotten mine or dungeon";
    $rarestuff[] = "a soldier's campaign chair that folds down and fits into an included scroll-case-sized container";
    $rarestuff[] = "a wooden box containing three cedar-scented pillar candles";
    $rarestuff[] = "a wooden box containing three bergamont-scented pillar candles";
    $rarestuff[] = "a wooden box containing three spice-scented pillar candles";
    $rarestuff[] = "a wooden box containing three savory-scented pillar candles";
    $rarestuff[] = "a wooden box containing three hour candles that change scent as well as color every hour while lit";
    $rarestuff[] = "a traveler's writing set, with two portable inkwells and two pens with metal nibs";
    $rarestuff[] = "a compact, traveller's book of fiction, titled <i>A Dove at Dawn</i>, by an anonymous author";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>A Merchant Master's Life</i>";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>A Merchant's Sagacity</i>";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>A Merchant's Tale</i>";
    $rarestuff[] = "a compact chapbook anonymously criticizing the current local royalty, titled <i>A Small but Treasonous Chapbook</i>";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>A Warrior's View</i>";
    $rarestuff[] = "a compact, traveller's book of collected advice, titled <i>A Wayfarer's Belt-Book of Advice</i>";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>An Old Warrior's Way</i>";
    $rarestuff[] = "a compact, traveller's book of navigational advice, titled <i>The Book of the Coast</i>";
    $rarestuff[] = "a compact, traveller's book of navigational advice, titled <i>The Book of the Rookeries</i>";
    $rarestuff[] = "a compact, traveller's book of navigational advice, titled <i>The Book of the Alusian Ocean and the Gulf of Brunei</i>";
    $rarestuff[] = "a compact, traveller's book of navigational advice, titled <i>The Book of the Isle of Garax</i>";
    $rarestuff[] = "a compact, traveller's book of collected memoir, titled <i>Memoirs of a Dragonslayer</i>";
    $rarestuff[] = "a compact, traveller's book of children's moral fiction, titled <i>Lessons to Children</i>, by an anonymous author";
    $rarestuff[] = "a compact, traveller's book of collected advice, titled <i>Letters to a Sheltered Son</i>";
    $rarestuff[] = "a compact, traveller's book of fiction, titled <i>Raging Blades: A Tale of the North</i>, by an anonymous author";
    $rarestuff[] = "a compact, traveller's book of children's fiction, titled <i>Slumbertime Stories for Sprites</i>, by an anonymous author";
    $rarestuff[] = "a compact, traveller's book of collected tactical, battlefield advice, titled <i>The Steel Prince's Field Guide to Tactics</i>";
    $rarestuff[] = "a compact, traveller's book of collected advice for running a large fiefdom, titled <i>To Rule a Realm, from Turret to Midden</i>";
    $rarestuff[] = "a compact, traveller's book of collected advice for running a large fiefdom, titled <i>On Running a Castle, from Pinacle to Postern</i>";
    $rarestuff[] = "a compact, traveller's book of collected advice for running a large manor, titled <i>Treatise on Good Wifery</i>";
    $rarestuff[] = "a compact, traveller's guidebook to unusual flora, titled <i>Treatise on the Flora of the Barrens of Sith</i>";
    $rarestuff[] = "a compact, traveller's guidebook to unusual flora, titled <i>Treatise on the Flora of the Mucklands</i>";
    $rarestuff[] = "a compact, traveller's guidebook to unusual flora, titled <i>Treatise on the Flora of the Wilderlands of Gilarni</i>";
    $rarestuff[] = "a compact, traveller's book of collected tactical, battlefield advice, titled <i>The Warrior Duke's Field Guide to Tactics</i> by the Demon Duke, Alloces";
    $rarestuff[] = "a compact, traveller's book of navigational advice, titled <i>The Book of Confederation Bay</i> by Iron Fist Baskor";
    $rarestuff[] = "a well-used Truesilver scepter, engraved with the likeness of an ancient king";
    $rarestuff[] = "a compact, extendable spyglass of brass and leather with surprisingly high-quality lenses";
    $rarestuff[] = "a child's metal top, with a hollow compartment containing a small parchment with a message written in code";
    $rarestuff[] = "a deck of playing cards featuring very good likenesses of local royalty on the face cards";
    $rarestuff[] = "a deck of fortune-telling cards of the highest quality in a hard, leather case chased with thread of gold";
    $rarestuff[] = "a small bag of cinnamon-scented incense";
    $rarestuff[] = "a small bag of cedar-scented incense";
    $rarestuff[] = "a compact, finely-made brass sextant and simple compass";
    $rarestuff[] = "a canvas hat with silk netting, like those used by beekeepers";
    $rarestuff[] = "a silk pillow, stuffed with feathers, in a protective canvas bag";
    $rarestuff[] = "a rolled woolen blanket with a black, silk sheet stitched to it";
    $rarestuff[] = "a small, oaken map tube, sealed against the elements containing ten pages of mapping parchment, a set of five colored charcoal markers, a quill pen with three nibs, a miniature bottle of ink, and a thin steel rule";
    $rarestuff[] = "a flagon-sized ceramic bottle of lilac-scented bath oil";
    $rarestuff[] = "a flagon-sized ceramic bottle of musk-scented bath oil";
    $rarestuff[] = "a traveler's writing set, with two portable inkwells and two pens with metal nibs and a sheaf of medium quality parchment";
    $rarestuff[] = "a traveler's writing set, with two portable inkwells and two pens with metal nibs and a compact, black, leather-bound blank journal";
    $rarestuff[] = "a flagon-sized ceramic bottle of citrus-scented bath oil";
    $rarestuff[] = "a paper envelope filled with seeds of unknown origin";
    $rarestuff[] = "the crimson and thread-of-gold robes of a Red Priest";
    $rarestuff[] = "a partial set of dentures made from exotic ivory and clearly sized for a normal sized human";
    $rarestuff[] = "a chalice made from a human skull";
    $rarestuff[] = "a silver whistle that sounds like a raven's call";
    $rarestuff[] = "an invitation to a party that occurred more than a week ago";
    $rarestuff[] = "a glass eye made from polished obsidian with a golden iris";
    $rarestuff[] = "an ivory back-scratcher in the shape of a demon's claw";
    $rarestuff[] = "an eye patch made from a black ribbon and a small, round sword hand guard of darkened steel chased with silver";
    $rarestuff[] = "an eye patch made from a black ribbon and a small, oval sword hand guard of darkened steel chased with silver";
    $rarestuff[] = "a sealed container of concentrated indigo dye";
    $rarestuff[] = "a pocket-sized, portable shrine dedicated to an obscure, foreign god";
    $rarestuff[]="a pair of wooden sandals from a very fine brothel";
    $rarestuff[]="a bar of cedar-scented soap";
    $rarestuff[]="a bar of pine-scented soap";
    $rarestuff[]="a bar of lilac-scented soap";
    $rarestuff[]="a bar of rose-scented soap";
    $rarestuff[]="a damaged and incomplete parchment map of a large, underground burial complex";
    
    $magicstuff[]="a small, black scarab that gives protection from insects when worn or carried";
    $magicstuff[]="a round, 9-inch fry-pan that automatically heats anything placed therein to frying temperature";
    $magicstuff[]="a rune-covered, bone brush that, upon utterance of the inscribed command, will groom the hair of the user";
    $magicstuff[]="a colored, glass ball that, when broken in front of the user, applies the cosmetic effect desired by the user";
    $magicstuff[]="a set of prayer beads made from indeterminate bone that makes the bearer invisible to the lesser undead";
    $magicstuff[]="a brass vial containing a potion of clairvoyance, 1 draught";
    $magicstuff[]="a carved, miniature chair that grows into a full-sized chair when the inscribed command word is spoken";
    $magicstuff[]="a one inch cube of crystal that will cool up to a gallon of fluid 20 degrees";
    $magicstuff[]="an oil lamp that can be commanded to light and extinguish at specific times";
    $magicstuff[]="a leather purse that does not allow sound of items within to be heard";
    $magicstuff[]="a silver whistle that can summon small storms, 1-8 charges";
    $magicstuff[]="a bedroll sewn into the shape of a bag that will keep the occupant warm and dry no matter the weather conditions outside the bag";
    $magicstuff[]="a miniature brass bucket that will extinguish normal campfires when the user mimes putting out a fire with the bucket";
    $magicstuff[]="a 9x5x3 inch box containing a set of miniature metal musicians which play a common/popular tune on command";
    $magicstuff[]="a pair of onyx dice that will give whatever result the roller desires";
    $magicstuff[]="a small pewter goblet that once filled with alcohol, will stay filled until the user becomes intoxicated";
    $magicstuff[]="a leather scroll case containing parchment scroll on which is inscribed a commonly known magic spell";
    $magicstuff[]="a small, flexible strip of metal that, when placed around the leg of a bird no larger than a hawk, keeps the bird within 5 feet of its owner";
    $magicstuff[]="a miniature, wooden chess set that will play an automated game of moderate level against the user";
    $magicstuff[]="a leather scroll case holding a fine, vellum scroll on which is inscribed a well known, but difficult magic spell";
    $magicstuff[]="a small, dark, crystal bowl that will fill with a delicacy spoken by the user which can be used ".mt_rand(1,10)." times/week";
    $magicstuff[]="an ordinary looking oil lamp that will light when the proper command is uttered within 15 feet of the lamp";
    $magicstuff[]="a small, frosted, glass jar that holds several spheres of ball lightning";
    $magicstuff[]="a small, glass jar holding an eye suspended in fluid that points toward the nearest source of treasure";
    $magicstuff[]="a sealed, glass sphere that contains a miniature, animated representation of paradise according to an ancient religion";
    $magicstuff[]="a leather scroll case holding a brittle, velum scroll on which is inscribed a well known, but very difficult magic spell";
    $magicstuff[]="an ebony flute that, upon command, floats in mid-air and plays a popular/common tune for 15 minutes";
    $magicstuff[]="an elegant, wooden pipe that allows the user to blow perfect smoke rings";
    $magicstuff[]="a bone scroll case holding a scroll with two spells of unknown origin";
    $magicstuff[]="a pouch containing ".mt_rand(1,10)." teardrop-shaped pills that, when dissolved in water, eliminate all effects of a hangover";
    $magicstuff[]="an ordinary looking oil lamp that needs no fuel to burn";
    $magicstuff[]="a tiny, silver replica of a dragon which is fully articulated and will animate for up to 30 minutes at the command of the owner";
    $magicstuff[]="a large ring holding a wide assortment of keys in various shapes, sizes and styles, which will open any lock the owner finds";
    $magicstuff[]="a blank book, bound in black leather, with a black, silk, ribbon closure that will magically fill the pages with whatever the holder speaks to it in a fine, dark, sepia ink written in small, precise, courtly script and the holder's native language";
    $magicstuff[]="a realistic-looking glass eye, which can be used as a prosthetic, and glows red when pointed at someone telling a lie";
    $magicstuff[]="a regular hammer similar to that used by carpenters, but that will never accidentally strike a finger";
    $magicstuff[]="a waxy, worn piece of leather that will protect one large loaf of bread from spoilage when wrapped around the loaf";
    $magicstuff[]="a blown glass goldfish that animates into a real goldfish when placed in sufficient container of liquid, but returns to glass when removed";
    $magicstuff[]="an old, worn chain with a tarnished copper pendant in the shape of an emaciated figure which keeps the wearer from gaining any weight while eating any amount of food";
    $magicstuff[]="a ceramic beetle which becomes animate and cleans the floor around you while you sleep";
    $magicstuff[]="a mask that makes the wearer's face appear upside-down";
    $magicstuff[]="a hoop that sharpens any blade passed through it";
    $magicstuff[]="a grimoire, bound in dragon hide, containing spells from a college specializing in fire magic";
    $magicstuff[]="a grimoire, bound in griffon skin, containing spells from a college specializing in air magic";
    $magicstuff[]="a grimoire, bound in tanned shark skin, containing spells from a college specializing in water magic";
    $magicstuff[]="a grimoire, bound between thin boards of ironwood, containing spells from a college specializing in earth magic";
    $magicstuff[]="a grimoire, bound in an unidentifiable reptilian hide, containing spells from a college specializing in summoning magic";
    $magicstuff[]="a grimoire, bound in tattooed human skin, containing spells from a college specializing in necromantic magic";
    $magicstuff[]="a gaudy gold eye patch, with a center-set ruby that lets the wearer see under all conditions, including complete darkness, regardless of the health, or presence of the eye behind the patch";
    $magicstuff[]="a grimoire, bound in troll skin, containing spells from a college specializing in enchantment magic and alchemy";
    $magicstuff[]="a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a partial set of dentures made from exotic ivory that will automatically fit the gap left by any missing teeth on any humanoid creature";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's fingernails to appear as copper";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's blood to appear as liquid silver";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's tears to appear as flecked with gold";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's hands to feel noticably and unnaturally cold to the touch";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's skin to appear as highly polished stone";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's entire body feel noticably warmer than normal to the touch";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's eyes to appear metallic in the light";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's blood to appear as completely transparent";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that causes the imbiber to grow feathers in their hair";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber to appear to exhale small clouds of steam";
    $magicstuff[]="a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's fingernails to appear as copper and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's blood to appear as liquid silver and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's tears to appear as flecked with gold and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's hands to feel noticably and unnaturally cold to the touch and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's skin to appear as highly polished stone and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's entire body feel noticably warmer than normal to the touch and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's eyes to appear metallic in the light and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber's blood to appear as completely transparent and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that causes the imbiber to grow feathers in their hair and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a small, ceramic vial containing a thin, grey potion that changes the imbiber to appear to exhale small clouds of steam and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy";
    $magicstuff[]="a feather quill that always has ink and a perpetually sharp nib";
    $magicstuff[]="a feather quill that can stiffen into a thin, but razor sharp knife, on command";
    $magicstuff[]="a copper coin that appears to be gold when not in direct sunlight";
    $magicstuff[]="a simple, leather-bound journal that appears to be a cookbook to everyone but the owner";
    $magicstuff[]="a feather quill pen that makes anything written with it appear in a beautiful, courtly script";
    $magicstuff[]="a golden circlet that hovers above the owner's head as if a halo";
    $magicstuff[]="a small, silver flask that changes any potable liquid poured into it into a potion that cures seasickness";
    $magicstuff[]="a feather quill that always has ink and a perpetually sharp nib";
    $magicstuff[]="a feather quill that can stiffen into a thin, but razor sharp knife, on command";
    $magicstuff[]="a copper coin that appears to be gold when not in direct sunlight";
    $magicstuff[]="a simple, leather-bound journal that appears to be a cookbook to everyone but the owner";
    $magicstuff[]="a feather quill pen that makes anything written with it appear in a beautiful, courtly script";
    $magicstuff[]="a golden circlet that hovers above the owner's head as if a halo";
    $magicstuff[]="a small, silver flask that changes any potable liquid poured into it into a potion that cures seasickness";
    $magicstuff[]="a pair of black, silk slippers that silence all sound of walking or running of the wearer";
    $magicstuff[]="a hooded lantern that prevents lies from being told by anyone illuminated by its light";
    $magicstuff[]="a small tin of ointment that hastens the healing of scars and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small tin of ointment that closes wounds otherwise requiring stitches and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, metallic vial containing a thin, clear potion that heals light wounds overnight and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, metallic vial containing a clear oil that grants the user flawless nightvision for an evening and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small tin of ointment that restores the vision of one blinded by poison and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, metallic vial containing a thin, clear potion that will cure the imbiber of all manner of disease and infection and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, ceramic vial containing a thin, clear potion that relieves the imbiber of all pain and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small tin of ointment that hastens the healing of scars";
    $magicstuff[]="a small tin of ointment that closes wounds otherwise requiring stitches";
    $magicstuff[]="a small, metallic vial containing a thin, clear potion that heals light wounds overnight";
    $magicstuff[]="a small, metallic vial containing a clear oil that grants the user flawless nightvision for an evening";
    $magicstuff[]="a small tin of ointment that restores the vision of one blinded by poison";
    $magicstuff[]="a small, metallic vial containing a thin, clear potion that will cure the imbiber of all manner of disease and infection";
    $magicstuff[]="a small, ceramic vial containing a thin, clear potion that relieves the imbiber of all pain";
    $magicstuff[]="a small, ceramic vial containing a thin, clear potion that counteracts any poison ingested by the imbiber and a grimoire, bound in fine-grained leather of unknown origin, containing encyclopedic knowledge of alchemy and medicine";
    $magicstuff[]="a small, ceramic vial containing a thin, clear potion that counteracts any poison ingested by the imbiber";
    $magicstuff[]="a grimoire, bound in leather so black that it seems to absorb light, containing spells from a college specializing in celestial and shadow magic";
    $magicstuff[]="a brass vial containing a potion granting the imbiber a night of restful sleep free of bad dreams";
    $magicstuff[]="a brass vial containing a potion which makes the imbiber repellant to the undead for one day";
    $magicstuff[]="a brass vial containing a potion which makes the imbiber impervious to fear for one day";

    $weapon[]="a simple, but razor sharp dagger in a plain sheath";
    $weapon[]="a stout cudgel";
    $weapon[]="a dagger in a plain sheath";
    $weapon[]="a short sword in a plain sheath";
    $weapon[]="a falchion and belt hanger";
    $weapon[]="a scimitar with a plain scabbard and belt hanger";
    $weapon[]="a plain rapier with a leather scabbard and belt hanger";
    $weapon[]="a sabre with a leather scabbard";
    $weapon[]="a broad sword with a leather scabbard";
    $weapon[]="a bastard sword with a leather scabbard";
    $weapon[]="a basket-hilted claymore with a leather scabbard and a shoulder hanger";
    $weapon[]="a two-handed claymore with a shoulder hanger";
    $weapon[]="a two-handed sword with a shoulder harness";
    $weapon[]="a hand axe";
    $weapon[]="a wood-handled mace";
    $weapon[]="a battle axe with shoulder harness";
    $weapon[]="a flail";
    $weapon[]="a morningstar";
    $weapon[]="a stout quarterstaff";
    $weapon[]="a shot-filled leather sap";
    $weapon[]="a brace of throwing knives with sheath";
    $weapon[]="a braided, leather whip";
    $weapon[]="a sling with ".mt_rand(1,10)." sling stones in a small pouch";
    $weapon[]="a short bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a recurve bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a long bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a heavy crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a stout cudgel";
    $weapon[]="an ornate and razor sharp dagger in a highly decorated sheath";
    $weapon[]="a stout cudgel made from exotic hardwood";
    $weapon[]="a dagger in a leather scabbard";
    $weapon[]="a silvered short sword in an ornate scabbard";
    $weapon[]="a falchion and belt hanger";
    $weapon[]="a ceremonial scimitar wrapped in ornate brocade cloth";
    $weapon[]="a matching rapier and main-gauche, each with a leather scabbard on a belt hanger";
    $weapon[]="a sabre with a leather scabbard";
    $weapon[]="a broad sword with a leather scabbard";
    $weapon[]="a single-edged bastard sword with a leather scabbard";
    $weapon[]="a two-handed sword with a shoulder harness";
    $weapon[]="a braided, leather whip";
    $weapon[]="a stout quarterstaff";
    $weapon[]="a wood-handled mace that has a head of stone carved to look like a fist";
    $weapon[]="a wood-handled mace that has a metal head cast to look like a fist";
    $weapon[]="a braided, leather whip";
    $weapon[]="a sling with ".mt_rand(1,10)." sling stones in a small pouch";
    $weapon[]="a short bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a recurve bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a long bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a light crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a stout quarterstaff shod in steel";
    $weapon[]="a simple, but razor sharp dagger in a plain sheath";
    $weapon[]="a short, razor-sharp knife in a plain, well-worn sheath";
    $weapon[]="a long, razor-sharp knife in a plain, well-worn sheath";
    $weapon[]="a dagger in a plain sheath";
    $weapon[]="a short sword in a plain sheath";
    $weapon[]="a simple, but razor sharp, silvered dagger in a plain sheath";
    $weapon[]="a stout cudgel";
    $weapon[]="a silvered dagger in a plain sheath";
    $weapon[]="a silvered short sword in a plain sheath";
    $weapon[]="a silvered falchion and belt hanger";
    $weapon[]="a silvered scimitar with a plain scabbard and belt hanger";
    $weapon[]="a plain rapier with a leather scabbard and belt hanger";
    $weapon[]="a silvered sabre with a leather scabbard";
    $weapon[]="a silvered broad sword with a leather scabbard";
    $weapon[]="a silvered bastard sword with a leather scabbard";
    $weapon[]="a silvered two-handed claymore with a shoulder hanger";
    $weapon[]="a silvered two-handed sword with a shoulder harness";
    $weapon[]="an ornate and razor sharp dagger in a highly decorated sheath";
    $weapon[]="a stout cudgel made from exotic hardwood";
    $weapon[]="a dagger in a leather scabbard";
    $weapon[]="a falchion and belt hanger";
    $weapon[]="a ceremonial scimitar wrapped in ornate brocade cloth";
    $weapon[]="a brace of throwing knives with sheath";
    $weapon[]="a braided, leather whip";
    $weapon[]="a sling with ".mt_rand(1,10)." sling stones in a small pouch";
    $weapon[]="a short bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a recurve bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a long bow with ".mt_rand(2,20)." arrows in a leather quiver";
    $weapon[]="a crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a heavy crossbow with ".mt_rand(2,20)." bolts in a leather quiver and a cranequin";
    $weapon[]="a garrote made from strong waxed cord with wooden toggles";
    $weapon[]="a garrote made from thin wire with carved ivory toggles";
    $weapon[]="a ceremonial scimitar, silvered, wrapped in ornate brocade cloth";
    $weapon[]="an ornate and razor sharp dagger which has been silvered, in a highly decorated sheath";
    $weapon[]="a simple, but razor sharp dagger in a plain sheath";
    $weapon[]="a single-edged short sword and a long, single-edged knife in matching styles";
    $weapon[]="two long, single-edged knives in matching styles";
    $weapon[]="a long, single-edged belt knife in a plain sheath";
    $weapon[]="a single-edged belt knife in a plain sheath";
    $weapon[]="a stout staff and a long, single-edged belt knife in a plain sheath";
    $weapon[]="two long, curved and ornate knives in matching styles and sheathes";

    // Random indices.
    $randomcoins  = random_int(0, count($coins) - 1);
    $randomjewelry = random_int(0, count($jewelry) - 1);
    $randomfoods  = random_int(0, count($foods) - 1);
    $randomrare   = random_int(0, count($rarestuff) - 1);
    $randommagic  = !empty($magicstuff) ? random_int(0, count($magicstuff) - 1) : 0;
    $randomweapon = !empty($weapon) ? random_int(0, count($weapon) - 1) : 0;

    // Start building markup.
    $output  = '<h3>Here\'s what they\'re carrying!</h3>';
    $output .= '<p>' . $bags[$randombags] . ' containing the following items:</p>';
    $output .= '<ul>';

    if (in_array('coins', $selected, TRUE)) {
      $output .= '<li>' . $coins[$randomcoins] . '</li>';
    }

    if (in_array('jewelry', $selected, TRUE)) {
      $output .= '<li>' . $jewelry[$randomjewelry] . '</li>';
    }

    if (in_array('foods', $selected, TRUE)) {
      $output .= '<li>' . $foods[$randomfoods] . '</li>';
    }

    if (in_array('others', $selected, TRUE)) {
      $output .= '<li>' . $rarestuff[$randomrare] . '</li>';
    }

    if (!empty($magicstuff) && in_array('magics', $selected, TRUE)) {
      $output .= '<li>' . $magicstuff[$randommagic] . '</li>';
    }

    if (!empty($weapon) && in_array('weapon', $selected, TRUE)) {
      $output .= '<li>' . $weapon[$randomweapon] . '</li>';
    }
    $output .= '</ul>';

    $output .= '<h3>Care to check again?</h3>';

    $output .= '<hr style="height:2px;width:100%;border-width:0;color:blue;background-color:black" />';

    $output .= '<p>This generator was inspired by Picked Pockets from ' .
      '<a href="http://web.archive.org/web/20001031203733/http://www.wraithsystemslabs.org:80/library.htm" target="_blank">Wraith Systems Labs</a> ' .
      'and the <a href="http://everyday-carry.com/" target="_blank">Every Day Carry website</a>.</p>';

    $output .= '<p>Please, support the creator by visiting, ' .
      '<a href="https://www.jkhoffman.com/use-your-words/">Use Your Words, a blog by JK Hoffman</a>.</p>';

    $output .= '<hr style="height:2px;width:100%;border-width:0;color:blue;background-color:black" />';

    return $output;
  }

}
