<?php

namespace FreeNote\FreeNoteBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

/**
 * Frontend page controller.
 */
class PageController extends Controller
{
    /**
     * Pages.
     *
     * @return Response
     */
    public function indexAction()
    {
        //TODO - przystosowac do obslugi wszystkich pages a nie tylko homepage
        $content = <<<EOF
<h1>Witaj na portalu Wolna Nuta</h1>
<p>Niedługo znajdziesz tu setki zespołów oraz tysiące utworów, które możesz kupić, ale przede wszystkim pobrać zupełnie za darmo. Jeśli jesteś muzykiem lub masz swój zespół i chcesz sprzedawać swoją twórczość, chcemy Ci pomóc.</p>
<p>Inicjatywa stworzenia naszego portalu zrodziła się na jednym z wrocławskich marszów protestacyjnych przeciwko ACTA. Uświadomiliśmy sobie wtedy, jak naprawdę działa dziś rynek muzyczny. Jeśli chcesz zaznajomić się z twórczością zespołu, zwykle nie kierujesz swoich pierwszych kroków w stronę sklepu muzycznego, lecz ściągasz utwory z internetu. To dla nas, pokolenia internautów, odruch absolutnie naturalny. Jednak w myśl aktualnego prawa jesteś złodziejem, "piratem", za co grozi Ci kara więzienia lub grzywny. </p>
<p>Sytuacja spowodowana jest uporczywym forsowaniem przez instytucje takie jak ZAiKS anachronicznych metod dystrybucji muzyki (i innych dóbr intelektualnych). Od czasu powstania tych instytucji świat i społeczeństwo mocno się zmieniły. Główną przyczyną zmian było powstanie internetu jako platformy wymiany danych. Powstałe społeczeństwo internautów ponad wszystko stawia sobie wolność słowa, a najważniejszym z priorytetów jest wolność wymiany informacji. </p>
<p>Zwapniałe systemy dystrybucji i promowania muzyki umiłowane przez wspomniane instytucje o ile kilkadziesiąt lat temu były całkowicie usprawiedliwione dziś, z racji postępu technologicznego, usprawiedliwienia nie znajdują. Obecnie, jeśli spodoba Ci się jakaś płyta, kupujesz ją i stawiasz na półce jako obiekt kolekcjonerski, gdyż większość z nas muzyki i tak słucha najczęściej na telefonie, odtwarzaczu mp3 lub komputerze osobistym. Nośnik fizyczny utracił status podstawowego nośnika danych na rzecz pliku mp3. Wolna Nuta jest serwisem promującym zarówno młodych, początkujących, jak też znanych, doświadczonych muzyków. Możesz tu pobrać plik za darmo, kupić płytę (lub inny gadżet) artysty lub wesprzeć twórców dobrowolną wpłatą przy pobieraniu. Możesz również uwolnić się od narzucanych przez media trendów muzycznych zagłębiając się w dziełach artystów, o których nigdy byś nie usłyszał bo nie mają nepotycznych znajomości w ZAiKSie czy RMF FM. Dziełach niejednokrotnie bardziej wartościowych od większości medialnej papki. </p>
<img src="/assets/img/glownaSmall.png" alt="Wolna Nuta">
<p>Kolejną wartą wspomnienia opcją jest przeniesienie do wirtualnego świata możliwości dobrowolnej dotacji artysty. Jeśli podoba Ci się muzyka, możesz wesprzeć jej twórcę drobną kwotą, aby wiedział, że komuś podobają się jego dzieła, a przez to miał motywację do dalszego działania. Dodatkowo dajesz nam w ten sposób wyraźny znak, w którego artystę powinniśmy mocniej zainwestować z racji jego ponadprzeciętności. Sami jesteśmy muzykami i niezwykle irytują nas problemy młodych zespołów, próbujących zrobić w naszym kraju karierę. Nie mają na to szans, ponieważ aby być dziś znanym w Polsce nie potrzebujesz talentu. Potrzebujesz pieniędzy i znajomości.</p>
<p>Tak! Przemysł muzyczny stanął na głowie. Wydawać by się mogło, że naturalna kolej rzeczy powinna wyglądać następująco:</p>
<p>Jeśli jesteś zdolny, ludzie Cię dostrzegają i śledzą Twoją twórczość. Dzięki temu zyskujesz popularność oraz zainteresowanie mediów, co przekłada się na zwiększenie grona odbiorców. W konsekwencji cały mechanizm pozwala Ci zarabiać niemałe na swojej pasji, ponieważ Twoja muzyka została doceniona przez publikę. Jesteś jednym ze szczęściarzy mogących utrzymywać się, robiąc to, co kochają. </p>
<p>Niestety tutaj pojawia się problem, ponieważ w rzeczywistości proces ten przedstawia się tak: </p>
<p>Jesteś bogat(y/a) i/lub masz tzw. „dojścia”-> -> okupujesz telewizyjne i radiowe stacje muzyczne -> -> wskutek pozornego braku alternatywy ludzie Cię znają i słuchają, choćbyś był(a) skrajnym beztalenciem -> -> masz jeszcze więcej pieniędzy, a muzyka schodzi na psy. </p>
<p>Z pomocą naszego serwisu pragniemy przywrócić naturalny bieg rzeczy. Serwis Wolna Nuta to nie tylko miejsce do odsłuchania i pobrania muzyki czy wsparcia artystów. Nasz serwis znajduje się obecnie we współpracy z osobami organizującymi festiwale i koncerty, dwoma studiami nagraniowymi oraz tłocznią płyt. Muzyka to nasza pasja. Pomóż nam przywrócić jej dawny blask, pomóż artystom przebić się przez skorumpowany mur show-businessu.</p>
<p>Jeśli jesteś zainteresowan(y/a) współpracą lub masz jakiekolwiek pytania, skontaktuj się z nami, pisząc pod ten adres: info@wolnanuta.pl, lub pod numerem telefonu 536 285 537.</p>
EOF;

        return $this->render('FreeNoteBundle:Frontend/Page:index.html.twig', array(
            'content' => $content,
        ));


//        //menu muzyczne
//        $catalog = $this->container->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_MUSIC_GENRE_SLUG);
//        $categories = $this->container->get('sylius_categorizer.manager.category')->findChildrenHierarchyCollection($catalog);
//
//        return $this->container->get('templating')->renderResponse(sprintf($catalog->getOption('templates.backend'), 'list'), array(
//            'catalog'    => $catalog,
//            'categories' => $categories
//        ));
//
//
//        $recentProducts = $this
//            ->getProductRepository()
//            ->findBy(array(), array('updatedAt' => 'desc'), 8)
//        ;
//
//        return $this->render('FreeNoteBundle:Frontend/Main:index.html.twig', array(
//            'recentProducts' => $recentProducts,
//        ));
    }

    private function getProductRepository()
    {
        return $this->get('sylius.repository.product');
    }
}
