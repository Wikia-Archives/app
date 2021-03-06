<?php
/** Vèneto (Vèneto)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author BrokenArrow
 * @author Candalua
 * @author Frigotoni
 * @author Kaganer
 * @author Nick1915
 * @author Omnipaedista
 * @author OrbiliusMagister
 * @author Reedy
 * @author Urhixidur
 * @author Vajotwo
 * @author לערי ריינהארט
 */

$magicWords = array(
	'redirect'                => array( '0', '#VARDA', '#RINVIA', '#RINVIO', '#RIMANDO', '#REDIRECT' ),
);

$fallback = 'it';

$namespaceNames = array(
	NS_MEDIA            => 'Media',
	NS_SPECIAL          => 'Speciale',
	NS_TALK             => 'Discussion',
	NS_USER             => 'Utente',
	NS_USER_TALK        => 'Discussion_utente',
	NS_PROJECT_TALK     => 'Discussion_$1',
	NS_FILE             => 'File',
	NS_FILE_TALK        => 'Discussion_file',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Discussion_MediaWiki',
	NS_TEMPLATE         => 'Modèl',
	NS_TEMPLATE_TALK    => 'Discussion_modèl',
	NS_HELP             => 'Ajuto',
	NS_HELP_TALK        => 'Discussion_ajuto',
	NS_CATEGORY         => 'Categoria',
	NS_CATEGORY_TALK    => 'Discussion_categoria',
);

$namespaceAliases = array(
	'Imagine' => NS_FILE,
	'Discussion_imagine' => NS_FILE_TALK,
	'Discussion_template' => NS_TEMPLATE_TALK,
	'Aiuto' => NS_HELP,
	'Discussion_aiuto' => NS_HELP_TALK,
);

$specialPageAliases = array(
	'Activeusers'               => array( 'UtentiAtivi' ),
	'Allmessages'               => array( 'Messagi' ),
	'Allpages'                  => array( 'TuteLePagine' ),
	'Ancientpages'              => array( 'PagineMancoNove' ),
	'Badtitle'                  => array( 'TitoloSbalià' ),
	'Blankpage'                 => array( 'PaginaVoda' ),
	'Block'                     => array( 'Bloca' ),
	'Blockme'                   => array( 'BlocaProxy' ),
	'Booksources'               => array( 'SercaISBN' ),
	'BrokenRedirects'           => array( 'RimandiSbalià' ),
	'Categories'                => array( 'Categorie' ),
	'ChangePassword'            => array( 'ReinpostaPassword' ),
	'ComparePages'              => array( 'ConfrontaPagine' ),
	'Confirmemail'              => array( 'ConfermaEMail' ),
	'Contributions'             => array( 'Contributi' ),
	'CreateAccount'             => array( 'CreaUtente' ),
	'Deadendpages'              => array( 'PagineSensaUscita' ),
	'DeletedContributions'      => array( 'ContributiScancelà' ),
	'Disambiguations'           => array( 'Disanbiguassion' ),
	'DoubleRedirects'           => array( 'DópiRimandi' ),
	'Emailuser'                 => array( 'MandaEMail' ),
	'Export'                    => array( 'Esporta' ),
	'Fewestrevisions'           => array( 'PagineConMancoRevision' ),
	'FileDuplicateSearch'       => array( 'SercaDopioniDeiFile' ),
	'Filepath'                  => array( 'PercorsoFile' ),
	'Import'                    => array( 'Inporta' ),
	'Invalidateemail'           => array( 'InvalidaEMail' ),
	'BlockList'                 => array( 'IPBlocài' ),
	'LinkSearch'                => array( 'SercaLigamenti' ),
	'Listadmins'                => array( 'Aministradori' ),
	'Listbots'                  => array( 'ListaDeiBot' ),
	'Listfiles'                 => array( 'ListaFile' ),
	'Listgrouprights'           => array( 'ListaDiritiDeGrupo' ),
	'Listredirects'             => array( 'Rimandi' ),
	'Listusers'                 => array( 'Utenti' ),
	'Lockdb'                    => array( 'BlocaDB' ),
	'Log'                       => array( 'Registri' ),
	'Lonelypages'               => array( 'PagineSolitarie' ),
	'Longpages'                 => array( 'PaginePiLonghe' ),
	'MergeHistory'              => array( 'FondiCronologia' ),
	'MIMEsearch'                => array( 'SercaMIME' ),
	'Mostcategories'            => array( 'PagineConPiassèCategorie' ),
	'Mostimages'                => array( 'FilePiassèDoparà' ),
	'Mostlinked'                => array( 'PaginePiassèRiciamà' ),
	'Mostlinkedcategories'      => array( 'CategoriePiassèDoparà' ),
	'Mostlinkedtemplates'       => array( 'ModèiPiassèDoparà' ),
	'Mostrevisions'             => array( 'PagineConPiassèRevision' ),
	'Movepage'                  => array( 'Sposta' ),
	'Mycontributions'           => array( 'IMeContributi' ),
	'Mypage'                    => array( 'LaMePaginaUtente' ),
	'Mytalk'                    => array( 'LeMeDiscussion' ),
	'Newimages'                 => array( 'FileNovi' ),
	'Newpages'                  => array( 'PagineNove' ),
	'Popularpages'              => array( 'PaginePiassèVisità' ),
	'Preferences'               => array( 'Preferense' ),
	'Prefixindex'               => array( 'Prefissi' ),
	'Protectedpages'            => array( 'PagineProtete' ),
	'Protectedtitles'           => array( 'TitoliProteti' ),
	'Randompage'                => array( 'PaginaAOcio' ),
	'Randomredirect'            => array( 'UnRimandoAOcio' ),
	'Recentchanges'             => array( 'ÙltimiCanbiamenti' ),
	'Recentchangeslinked'       => array( 'CanbiamentiLigà' ),
	'Revisiondelete'            => array( 'ScancelaRevision' ),
	'RevisionMove'              => array( 'SpostaRevision' ),
	'Search'                    => array( 'Serca' ),
	'Shortpages'                => array( 'PaginePiCurte' ),
	'Specialpages'              => array( 'PagineSpeciali' ),
	'Statistics'                => array( 'Statìsteghe' ),
	'Tags'                      => array( 'Tag' ),
	'Unblock'                   => array( 'Desbloca' ),
	'Uncategorizedcategories'   => array( 'CategorieSensaCategorie' ),
	'Uncategorizedimages'       => array( 'FileSensaCategorie' ),
	'Uncategorizedpages'        => array( 'PagineSensaCategorie' ),
	'Uncategorizedtemplates'    => array( 'ModèiSensaCategorie' ),
	'Undelete'                  => array( 'Ripristina' ),
	'Unlockdb'                  => array( 'DesblocaDB' ),
	'Unusedcategories'          => array( 'CategorieMiaDoparà' ),
	'Unusedimages'              => array( 'FileMiaDoparà' ),
	'Unusedtemplates'           => array( 'ModèiMiaDoparà' ),
	'Unwatchedpages'            => array( 'PagineMiaTegnùDeOcio' ),
	'Upload'                    => array( 'Carga' ),
	'Userlogin'                 => array( 'Entra' ),
	'Userlogout'                => array( 'VàFora' ),
	'Userrights'                => array( 'ParmessiUtente' ),
	'Wantedcategories'          => array( 'CategorieDomandà' ),
	'Wantedfiles'               => array( 'FileDomandà' ),
	'Wantedpages'               => array( 'PagineDomandà' ),
	'Wantedtemplates'           => array( 'ModèiDomandà' ),
	'Watchlist'                 => array( 'TegnùiDeOcio' ),
	'Whatlinkshere'             => array( 'PuntaQua' ),
	'Withoutinterwiki'          => array( 'PagineSensaInterwiki' ),
);

