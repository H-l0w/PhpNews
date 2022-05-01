DROP DATABASE IF EXISTS news;

CREATE DATABASE news
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE roles(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE users(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
	username VARCHAR(100),
    email VARCHAR(100),
    password varchar(200),
    id_role INT(6) UNSIGNED,
    image_url VARCHAR(500),
    description VARCHAR(500),
    CONSTRAINT fk_id_role FOREIGN KEY (id_role)
    REFERENCES roles(id)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE categories(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    description VARCHAR(200),
    image_url VARCHAR(500)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE articles(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date datetime,
    id_author INT(6) UNSIGNED,
    id_category INT(6) UNSIGNED,
    title varchar(200),    
    text text,
    visible boolean,
    image_url varchar(500),
    CONSTRAINT fk_id_author FOREIGN KEY (id_author)
    REFERENCES users(id),
    CONSTRAINT fk_id_category FOREIGN KEY (id_category)
    REFERENCES categories(id)
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

CREATE TABLE comments(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_article INT(6) UNSIGNED,
    name varchar(50),
    email varchar(100),
    text text,
    date DATETIME,
    CONSTRAINT fk_id_article FOREIGN KEY (id_article)
    REFERENCES articles(id) ON DELETE CASCADE   
)
DEFAULT CHARACTER SET utf8
COLLATE utf8_czech_ci;

INSERT INTO roles VALUES(DEFAULT, 'Administrator');
INSERT INTO roles VALUES(DEFAULT, 'Editor');

INSERT INTO categories VALUES(DEFAULT, 'Domácí', 'Nejnovější zprávy o dění v České republice', 'https://images.pexels.com/photos/1269805/pexels-photo-1269805.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
INSERT INTO categories VALUES(DEFAULT, 'Svět', 'Nejnovější zprávy o dění ve světě', 'https://cdn.pixabay.com/photo/2016/10/20/18/35/earth-1756274_960_720.jpg');
INSERT INTO categories VALUES(DEFAULT, 'Regiony', 'Nejnovější zprávy o děním v regionech České republiky', 'https://www.worldatlas.com/upload/70/09/5b/regions-of-czech-republic-map.png');
INSERT INTO categories VALUES(DEFAULT, 'Ekonomika', 'Nejnovější zprávy z oblasti ekonomiky, ať už ze světa tak z Česka', 'https://images.pexels.com/photos/730547/pexels-photo-730547.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
INSERT INTO categories VALUES(DEFAULT, 'Kultura', 'Nejnovější zprávy z oblasti kultury, ať už ze světa tak z Česka', 'https://images.pexels.com/photos/1313814/pexels-photo-1313814.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260');
INSERT INTO categories VALUES(DEFAULT, 'Média', 'Nejnovější zprávy z světového i Českého medialního prostoru', 'https://images.pexels.com/photos/267350/pexels-photo-267350.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
INSERT INTO categories VALUES(DEFAULT, 'Věda', 'Nejnovější zprávy na poli vědy a techniky z celého světa', 'https://images.pexels.com/photos/2156/sky-earth-space-working.jpg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
INSERT INTO categories VALUES(DEFAULT, 'Počasí', 'Nejnovější přehled o počasí z Česka a Evropy', 'https://images.pexels.com/photos/76969/cold-front-warm-front-hurricane-felix-76969.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');

INSERT INTO users VALUES(DEFAULT, 'Saša', 'Vobořil','voboril.sasa','voborilsasa@sssvt.cz','$2y$10$XVwQJOZ3JvX5bjQNxdwaeeMM2pjRPI8qSwgWryETkRjPrdxWcJI4K', 1, 'https://steamuserimages-a.akamaihd.net/ugc/885384897182110030/F095539864AC9E94AE5236E04C8CA7C2725BCEFF/', 'Vystudoval žurnalistiku na Univerzitě Palackého v Olomouci a mediální studia na Univerzitě Karlově. První zkušenosti sbíral jako redaktor filmových a zahraničních témat na serveru Týden.cz, poté strávil rok v televizním zpravodajství CNN Prima News. Do redakce Práva nastoupil v květnu 2021.');
INSERT INTO users VALUES(DEFAULT, 'Radim', 'Nedvěd','radim.nedved','nedvedradim@sssvt.cz','$2y$10$XVwQJOZ3JvX5bjQNxdwaeeMM2pjRPI8qSwgWryETkRjPrdxWcJI4K', 1, 'https://steamuserimages-a.akamaihd.net/ugc/885384897182110030/F095539864AC9E94AE5236E04C8CA7C2725BCEFF/', 'Vystudoval žurnalistiku na Univerzitě Palackého v Olomouci a mediální studia na Univerzitě Karlově. První zkušenosti sbíral jako redaktor filmových a zahraničních témat na serveru Týden.cz, poté strávil rok v televizním zpravodajství CNN Prima News. Do redakce Práva nastoupil v květnu 2021.');
INSERT INTO users VALUES(DEFAULT, 'Matěj', 'Procházka','prochazka.matej','prochazkamatej@sssvt.cz','$2y$10$XVwQJOZ3JvX5bjQNxdwaeeMM2pjRPI8qSwgWryETkRjPrdxWcJI4K',1, 'https://steamuserimages-a.akamaihd.net/ugc/885384897182110030/F095539864AC9E94AE5236E04C8CA7C2725BCEFF/', 'Vystudoval žurnalistiku na Univerzitě Palackého v Olomouci a mediální studia na Univerzitě Karlově. První zkušenosti sbíral jako redaktor filmových a zahraničních témat na serveru Týden.cz, poté strávil rok v televizním zpravodajství CNN Prima News. Do redakce Práva nastoupil v květnu 2021.');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 1, 1, 'Policisté ukončili prověřování okolí prezidenta Miloše Zemana kvůli možnému podezření z neposkytnutí pomoci v době před hospitalizací prezidenta.', 'Okresní státní zastupitelství v Rakovníku, které mělo případ na starosti, potvrdilo odložení věci na svém webu. "Ve věci neposkytnutí pomoci panu prezidentovi republiky sděluji, že usnesením policejního orgánu ze dne 23. 02. 2022 bylo rozhodnuto o odložení věci podle § 159a odst. 1 trestního řádu, kdy policejní orgán dospěl k závěru, že nejde o podezření z trestného činu a nebylo na místě věc vyřídit jinak," napsal šéf rakovnických žalobců Lukáš Hossinger. Doplnil, že rozhodnutí je konečné.
Zemana převezla ambulance do Ústřední vojenské nemocnice (ÚVN) z lánského zámku loni v neděli 10. října, tedy až po volbách do Sněmovny a krátce po odjezdu tehdejšího premiéra Andreje Babiše (ANO). Na záběrech pořízených před nemocnicí byl Zeman v bezvládném stavu.
Podle Hradu byl prezident dva týdny předtím nemocen, svůj hlas ve sněmovních volbách proto odevzdal přímo v Lánech a na doporučení svého ošetřujícího lékaře, ředitele ÚVN Miroslava Zavorala zrušil nedělní účast v televizní debatě. Spekulovalo se o tom, že Zemanovi blízcí spolupracovníci - tedy Mynář, mluvčí Jiří Ovčáček či poradce Martin Nejedlý - mu předtím nezajistili dostatečnou pomoc. Mynář to kategoricky odmítl s tím, že všichni z prezidentova okolí i Zavoral pravidelně Zemana přesvědčovali, aby souhlasil s hospitalizací.
"Vždycky byl nutný souhlas pana prezidenta jako osoby svéprávné a svébytné. Bohužel podařilo se to až na tu neděli po volbách. Do té doby jsme dělali všichni všechno pro to, aby se to podařilo," zdůraznil Mynář v listopadu, kdy podával vysvětlení na policii. Trestní oznámení, která v této souvislosti obdržela policie, označil za politickou záležitost. Kromě Mynáře si policie předvolala například také šéfa ochranky prezidenta Martina Baláže či hradního protokoláře Vladimíra Kruliše.
Trestní oznámení podal v této věci například lékař Martin Jan Stránský. Bezvládný stav prezidenta při příjezdu do nemocnice podle něj mohla způsobit buď jen absolutní neprofesionalita a nedbalost personálu sanitky, nebo šlo o běžnou kondici hlavy státu.
Druhý případ související se Zemanovou hospitalizací, tedy podezření na možné padělání veřejné listiny či na přisvojení pravomoci úřadu, řešilo Obvodní státní zastupitelství pro Prahu 6. Podezření souviselo s tím, že Zeman pobýval v době podpisu listiny, kterou mu přinesl tehdejší předseda dolní parlamentní komory Radek Vondráček (ANO), na jednotce intenzivní péče. Policie ale dospěla k závěru, že Zeman dokument podepsal sám, dobrovolně a při vědomí.
Pochybnosti o pravosti prezidentova podpisu na listině vyvolala zpráva lékařů, kterou od ÚVN obdržel předseda Senátu Miloš Vystrčil (ODS) a podle které Zeman nebyl v dané době schopen vykonávat pracovní povinnosti. Mynář následně zveřejnil záběry zachycující Zemana, jak v nemocnici dokument podepisuje. Uvedl také, že prezident ho pověřil přípravou listiny o svolání Sněmovny ještě před svou hospitalizací.',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/2560689-f202105101383001.jpeg?itok=ysx6o_l_');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 2, 2, 'Dokažte, že jste při nás, apeloval na europoslance Zelenskyj. Shoda na žádosti Kyjeva ale bude složitá', 'Ve středu se na plenárním zasedání mimořádně sešel Evropský parlament. Poslanci by měli hlasovat o rezoluci požadující urychlení ukrajinské kandidatury do Evropské unie. Ukrajinský prezident Volodymyr Zelenskyj před plénem prohlásil, že Ukrajinu nic nezlomí. Země podle něj obětovává své nejlepší lidi a usiluje o to, aby byla rovnocenným partnerem v Evropě. Předseda Evropské rady Charles Michel připustil, že EU musí seriózně projednat ukrajinskou žádost, dosáhnout jednomyslné shody však bude dle něj složité.',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/2628828-2022-03-01t163230z_395956628_rc2sts9aobse_rtrmadp_3_ukraine-crisis-zelenskiy-interview.jpg?itok=wge5vNZp');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 3,3, 'Ústí nad Labem nebude za Mariánský most doplácet miliony. Města se zastal odvolací soud', 'Spor se vedl od roku 1999, kdy dodavatel (Hutní montáže) podal na město žalobu. Hutní montáže nejprve požadovaly 184 milionů korun a úrok z prodlení. Odvolací krajský soud vydal pravomocné rozhodnutí loni na konci března. V rozsudku dal za pravdu městu. „Odvolací soud dospěl k závěru, že nebylo prokázáno, že by za město uzavřely dohodu o změně díla osoby k tomu oprávněné, proto jsme shledali nárok na doplatek změněné ceny díla neoprávněným a žalobu jsme v tomto rozsahu zamítli,“ řekl tehdy soudce Vladimír Beran.
Odmítnutí dovolání znamená, že rozsudek krajského soudu zůstává platný. „Je to potvrzení naší snahy dosáhnout spravedlnosti v tomto dlouholetém sporu (…) Hrozil vážný zásah do financování města,“ uvedl tajemník magistrátu Miloš Studenovský.',1,'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/1820252-p201601180318401.jpeg?itok=UP5PEpS1');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 1,4, 'Letošním evropským Autem roku je elektrická Kia EV6','Porota vybírala z celkem devětatřiceti letošních evropských automobilových novinek. Mezi sedmičkou finalistů pak byly ještě modely Cupra Born, Ford Mustang Mach-E, Hyundai Ioniq 5, Peugeot 308 a Renault Mégane E-Tech. Šest vozů ve finále bylo čistě elektrických a jeden měl hybridní pohon.
Kia EV6 je jako první elektromobil značky postavený na globální modulární platformě E-GMP, kterou sdílí například s Hyundai Ioniq. Vůz pohání elektromotor s výkonem 125 kW a na jedno nabití ujede necelých čtyři sta kilometrů. Silnější provedení s 168 kW ujede až 528 kilometrů. Na ujetí sta kilometrů se nabije za pět minut.
Podle českého zástupce v porotě Jiřího Duchoně Kia zaujme originálním vzhledem, ale rovněž nejmodernější elektrickou 800V platformou. „Umožňuje nabíjet i na 350kW stanicích. K dispozici je s pohonem zadních, nebo všech kol. Kia EV6 má vpředu objemnou odkládací schránku a nabízí velkorysý a dobře vybavený vnitřní prostor,“ uvedl Duchoň.',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/images/2628580-2021-11-17t201252z_1899432918_rc2jwq9ao6dc_rtrmadp_3_autoshow-los-angeles.jpg?itok=Rd1Etfip');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 2,5, 'Volodymyr Zelenskyj se ukazuje jako komik, kterého je třeba brát vážně','Volodomyr Zelenskyj se proslavil už jako mladík v ukrajinské obdobě české Partičky s názvem Klub vtipných a pohotových. S kolegy pak založil komediální skupinu Kvartal 95. Točil komediální filmy – poslední titul Ja, ty, vin, vona (Já, ty, on, ona) si vybral dokonce jako svůj celovečerní režijní debut. Romantická komedie o partnerském čtyřúhelníku se stala diváckým hitem. Tančil také v ukrajinské obdobě StarDance – a soutěž vyhrál.
Největší popularitu mu získala role prezidenta v seriálu Sluha lidu. Původně učitel dějepisu se do čela státu dostane díky virálnímu videu, v němž nadává na korupci a nevalné vyhlídky své země.
„Nejsme žebráci, nejsme gastarbeiteři. Zapamatujte si jednou provždy, že nejsme periferie. Nejsme hranice mezi orky a elfy. Jsme normální, silná, krásná a bohatá země,“ připomíná fiktivní hlava státu v jednom ze svých proslovů, který by mohl pronést dnes i skutečný ukrajinský prezident.',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/2628498-30c9606aabfce0c34f57516416544a30.jpg?itok=5ue0x8En');

INSERT INTO articles values(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 3,6, 'Google utne ruským státním médiím peníze z reklamy, Musk nad Ukrajinou aktivoval Starlink','Google upřesnil, že bude bránit ruským státním médiím v tom, aby používala jeho reklamní technologii ke generování příjmů na jejich vlastních stránkách a v aplikacích.
Média kromě toho už nebudou mít možnost kupovat reklamu prostřednictvím nástroje Google Tools a umísťovat reklamu na platformách internetové společnosti, jako je její vyhledávač nebo e-mailová služba Gmail.
Také provozovatel internetových stránek pro přehrávání videí YouTube zakázal v sobotu mediální společnosti RT a dalším kanálům, z nichž některé jsou spojeny s protiruskými sankcemi, aby dostávaly peníze z videí umísťovaných na jeho platformě. YouTube, který patří pod společnost Google, z velké části kontroluje umísťování reklamy.',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/images/2628318-2022-02-27t074158z_625404728_rc2wrs9ltchb_rtrmadp_3_ukraine-crisis-youtube.jpg?itok=YQtIHnVk');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 1,7, 'Nová zpráva o klimatu je vážné varování i pro Česko, shodli se experti','
Je třeba zrychlit snižování emisí skleníkových plynů a urychlit adaptační opatření na změnu klimatu. Zároveň je však nutné provádět adaptační opatření dostatečně a správně. K obsahu v pondělí zveřejněné druhé části šesté hodnotící zprávy Mezivládního panelu pro změny klimatu (IPCC) při OSN to sdělili experti z akademické sféry, ekologických organizací a Českého hydrometeorologického ústavu (ČHMÚ) na konferenci v Praze.
',1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/images/2323709-f201907093142801.jpeg?itok=GRnzviqw');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 2,8, 'Březen odstartoval mrazivým ránem','Ranní teploty v úterý klesaly hluboko pod bod mrazu v důsledku převážně jasné oblohy a slabého větru. Zřejmě nejchladněji bylo na Jizerce u Kořenova v Jizerských horách, kde teplota klesla pod minus 22 stupňů Celsia, jak vyplývá z údajů na webu ČHMÚ.
Velmi chladno bylo také na šumavské Horské Kvildě, kde se podle meteorologů teplota dostala na minus 18,5 stupně Celsia. V Bedřichově na Jablonecku bylo kolem minus 17 stupňů.
„Je možné, že v příštích hodinách budou teploty ještě trošku klesat, k rekordu z roku 2005, kdy bylo 1. března na stanici Kvilda-Perla naměřeno minus 33,3 stupně Celsia, máme ale ještě daleko,“ uvedl ČHMÚ kolem úterních 7:30 hodin.', 1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/images/2532960-p202101310518501.jpeg?itok=CH3UrwbX');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 3,4,'Washington eviduje záměrné ruské útoky na civilisty. Je to teroristický stát, zdůraznila ukrajinská ambasadorka
', 'Světová zdravotnická organizace (WHO) potvrdila „několik“ útoků na ukrajinská zdravotnická zařízení, při nichž umírali lidé, a podezření na další vyšetřuje. „Ataky na zdravotnická zařízení či zdravotníky porušují lékařskou neutralitu a jsou porušením mezinárodních humanitárních norem,“ upozornil šéf WHO Tedros Adhanom Ghebreyesus.
Také Washington má podle ministra zahraničí Antonyho Blinkena velmi důvěryhodné zprávy o vědomých útocích ruské armády na civilisty. Spojené státy evidují důkazy, aby mohly zodpovědné organizace vyšetřit, zda došlo k válečným zločinům. Po vyšetřování volá také šéfka Evropské komise Ursula von der Leyenová.
„Rozsah a síla ukrajinského odporu Rusko neustále překvapuje,“ píše v nové zprávě britská vojenská rozvědka. Ruská armáda na to podle zpravodajců reaguje tím, že se zaměřuje na obydlené oblasti v Charkově, Černihivu či Mariupolu, čímž chce zlomit ukrajinskou morálku.
„Rusko je teroristický stát a měli bychom se k němu chovat jako k teroristickému státu,“ zdůraznila ukrajinská ambasadorka u OSN Oksana Markarovová.
Úřad Vysokého komisaře OSN pro lidská práva eviduje od začátku ruské invaze potvrzených 364 mrtvých civilistů. Skutečné číslo ale může být mnohem vyšší „obzvlášť ve vládou kontrolovaných územích a zejména v posledních dnech“, konstatuje OSN. Ta oznamuje pouze oběti, které se jí podaří podle přísné metodologie potvrdit.
Rusko se stalo terčem kritiky také za to, že zaútočilo na Záporožskou jadernou elektrárnu. Kremelský vůdce Putin v neděli prohlásil, že „incident“ byl výsledkem „provokací ukrajinských radikálů“.', 1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/2629828-p2022030604529.jpeg?itok=jL5gGWby');

INSERT INTO articles VALUES(DEFAULT,CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 *60) SECOND, 1,4,'Nabitý program. Vláda bude řešit nejen další pomoc Ukrajině, ale i rekordně drahá paliva', 'Ceny benzinu a nafty nad 40 korun za litr. Řidiči si na ně kvůli válce na Ukrajině už několik dní zvykají. Vláda ve středu projedná, jak růst cen pohonných hmot zastavit nebo aspoň zmírnit.
„Nejdřív musíme mít analýzu, ta bude hotová v řádu hodin nebo desítek hodin. A na základě toho ve spolupráci s panem ministrem průmyslu a obchodu případně předložíme vládě příští týden ve středu (návrh), jak by mohla česká vláda zareagovat,“ vysvětluje Stanjura.
Zatímco třeba Polsko snížilo od začátku února DPH z pohonných hmot z 23 na 8 procent, Maďarsko stanovilo maximální možnou cenu zhruba na 33 korun za litr. „Možná to bude kombinace různých přístupů, protože těch metod je několik. Ale všechny jsou komplikované, to je třeba říct, protože zejména v otázce pohonných hmot je tady vysoce konkurenční prostředí,“ má jasno ministr financí.', 1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/file-video_16x9/public/2620320-stanjura.jpg?itok=IkwHKpJv');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 * 60) SECOND,2,1,'Herní svět bojuje i ve skutečnosti: Zaklínač se stahuje z Ruska, střílení v Doomu pomáhá Ukrajině', 'Ukrajinské studio GSC Game World pozastavilo vývoj hry S.T.A.L.K.E.R. 2: Heart of Chernobyl. Postapokalyptický příběh se odehrává v oblasti zasažené jadernou havárií. V herním světě je obývaná hledači pokladů a mutantů, ve skutečném ji momentálně drží ruská armáda.
Budeme pokračovat, až zvítězíme, vzkázali fanouškům autoři. Na sociálních sítích zveřejnili z přípravy hry video o motion capture, tedy nahrávání pohybu pro digitální model, a doplnili ho reálnými záběry z válkou zasažené Ukrajiny.
Vzápětí po napadení Ukrajiny zareagovali třeba polští 11 bit studios. Jejich oceňovaná hra This War of Mine z roku 2014 ukazuje válečný konflikt z pohledu civilistů. Všechny výdělky z ní za poslední týden – v přepočtu přes šestnáct milionů korun – hodlají poslat Červenému kříži. Podobně peníze z některých svých her daruje i třeba české studio Amanita Design. Na konto Člověka v tísni věnovala část výdělků z prodejů her Machinarium, Creaks a Chuchel.
Herní designér John Romero se rozhodl vyjádřit podporu tím, co nejlépe umí – po mnoha letech vytvořil novou úroveň pro druhý Doom. Počítačovou hru, která pomohla definovat „střílečky“ z pohledu postavy, za níž člověk hraje. Na akci elitního mariňáka vyslaného na Mars navázal nyní levelem One Humanity, veškerý výdělek putuje přes humanitární organizace na pomoc Ukrajině.', 1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/file-video_16x9/public/2630150-199597904_6338750616150800_4203402047064441844_n.jpg?itok=xFnGe7CZ');

INSERT INTO articles VALUES(DEFAULT,CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 * 60) SECOND, 3, 6, 'Bitcoin se stává ekologickým problémem. Na jeho těžbu se víc využívají fosilní paliva', 'Na konci února 2022 vyšel v odborném časopisu Joule článek, který popsal, jak přesun těžařů digitální měny z Číny do USA způsobil, že se z bitcoinu stala ještě méně ekologická záležitost. Hlavní příčinou je, že v Číně se měna těžila pomocí energie z vodních elektráren, ale ve Spojených státech se potřebná elektřina získává spalováním uhlí. Energetická náročnost bitcoinu se tak za jediný rok zvýšila o sedmnáct procent.
Zastánci bitcoinu přitom předpokládali, že se stane pravý opak. Hlavním autorem studie je Alex de Vries, který sestavuje takzvaný Bitcoin Energy Consumption Index – tedy škálu, která sleduje, jak moc energie je zapotřebí k těžbě bitcoinů i obchodování s nimi.
De Vries a spoluautoři studie použili pravidelně aktualizovanou mapu globálního rozmístění těžařů bitcoinů na základě jejich IP adres, kterou jim poskytlo cambridgeské Centrum pro alternativní finance. Tato datová sada sleduje téměř polovinu bitcoinové sítě, takže je podle vědců dostatečně reprezentativní na to, aby o ní něco vypovídala. Vědci pak sledovali, jak se změnila místa, kde se bitcoiny těží – srovnávali přitom srpen 2020 a stejný měsíc roku 2021. Na základě údajů o množství fosilních paliv a obnovitelných zdrojů energie, které spotřebovávají sítě v jednotlivých lokalitách, byli výzkumníci schopni odvodit, jaké druhy paliva těžaři bitcoinů používají, a extrapolovat z toho přibližnou uhlíkovou stopu pro celou síť', '1', 'https://ct24.ceskatelevize.cz/sites/default/files/styles/node-article_horizontal/public/2586436-f202108310771501.jpeg?itok=DSv0tFer');

INSERT INTO articles VALUES(DEFAULT, CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14 * 24 * 60 * 60) SECOND, 2, 2, 'Více než polovina ukrajinských uprchlíků jsou děti. Speciální víza jich v Česku má přes 57 tisíc
', 'Asistenční středisko pro pomoc uprchlíkům z Ukrajiny v pražském Kongresovém centru jen v neděli odbavilo 3284 lidí, 180 z nich zajistilo ubytování, informoval na Twitteru primátor Zdeněk Hřib (Piráti). Celkem podle ranních informací centrum od začátku ruské invaze evidovalo na dvanáct tisíc osob. Primátor v pondělí krátce po poledni také dodal, že asistenční centrum začíná být přehlceno, proto magistrát požádal o řešení situace stát. Hasičský záchranný sbor posléze na svém Twitteru informoval, že s ohledem na čekací lhůty nebude centrum nové uprchlíky přijímat.
Hřib avizoval, že otevření pro další uprchlíky nastane po odbavení nyní čekajících lidí, tedy v úterý. Centrum pracuje nonstop. „V momentě, kdy se podaří tyto lidi zpracovat, není problém začít přijímat další, ale bude to řízeno operativně,“ řekl primátor. Centrum nyní operativně řídí policie.Podle mluvčí hasičského sboru Pavly Jakoubkové hasiči vypravili čtyři autobusy s uprchlíky do dalších krajských center, dva zamířily do Jihočeského kraje, jeden do Kutné Hory a jeden do Liberce. Tam by měli lidé najít i ubytování, které už je v Praze vyčerpáno. „Máme v tuto chvíli informaci o tom, že i ta ostatní asistenční centra jsou plně vytížena,“ uvedl Hřib s tím, že další postup je nutné řešit na vládní úrovni.', 1, 'https://ct24.ceskatelevize.cz/sites/default/files/styles/file-video_16x9/public/images/2630050-p20220307033411.jpeg?itok=jAemZEPO');