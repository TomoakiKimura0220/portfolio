package jp.ac.ait.k21231;

import com.sun.security.jgss.GSSUtil;

import java.util.Random;
import java.util.Scanner;

public class SimpleRPG {

    // このクラスでは、画面からの入力をいろいろなメソッドで行うため、
    // フィールド化しておく
    final static Scanner scanner = new Scanner(System.in);
    //Scannerは一つでいいからfinal
    //実行時すでに準備しておくためにstatic

    Hero hero;
    Enemy enemy;

    /**
     * 勇者を生成して返すメソッド
     * @return
     */
    Hero createHero() {

        //勇者の名前を入力させます
        System.out.println("勇者の名前を入力入力してください。");
        String name = scanner.nextLine();

        // 以下の表に従ってパラメータを生成
        Hero hero = new Hero( // パラメータ	ランダム範囲
                name,
                new Random().nextInt(41) + 80,  // HP	80 〜 120
                new Random().nextInt(8) + 8,   // ATK	8 〜 15
                new Random().nextInt(8) + 8,   // DEF	8 〜 15
                new Random().nextInt(8) + 8);  // AGI	8 〜 15
        //職業選択
        return selectJob(hero);
    }

    Hero selectJob(Hero heroInstance) {
        while(true) {
            System.out.println("職業を選択してください。(1: 弓使い、2: 戦士)");
            //職業によってステータスボーナス
            String input = scanner.nextLine();
            if(input.equals("1")) {
                return new Archer
                        (
                                heroInstance.getName(),
                                heroInstance.getHp(),
                                heroInstance.getAtk() + 5,
                                heroInstance.getDef(),
                                heroInstance.getAgi() + 5
                        );
            }
            if(input.equals("2")) {
                return new Warrior
                        (
                                heroInstance.getName(),
                                heroInstance.getHp() + 10,
                                heroInstance.getAtk(),
                                heroInstance.getDef() + 10,
                                heroInstance.getAgi()
                        );
            }
        }
    }

    Enemy createEnemy() {

        //課題2-1.敵の名前の変更
        //敵の名前っぽい食べ物の名前に変更
        final String[] ENEMY_NAMES = {"ビーフストロガノフ", "ゴルゴンゾーラ", "ブラックサンダー", "ドリアン", "ハルサメ"};

        // 上記配列から、ランダムに1つだけの名前を抽出して敵の名前とする。
        String name = ENEMY_NAMES[new Random().nextInt(ENEMY_NAMES.length)];

        Enemy enemy = new Enemy( // パラメータ	ランダム範囲
                name,
                new Random().nextInt(151) + 50,  // HP  	50 〜 200
                new Random().nextInt(11) + 10,  // ATK	10 〜 20
                new Random().nextInt(11) + 5,   // DEF	5 〜 15
                new Random().nextInt(11) + 10); // AGI	10 〜 20

        return enemy;

    }

    /**
     *  勇者の行動
     * @return falseの場合続行不能
     */
    boolean heroAction() {
        // 勇者の1回分の行動決定と行動を行わせるメソッド

        // 画面より、攻撃か逃亡かを選択させ、その行動結果を画面に表示します
        System.out.println("-------------------------");
        System.out.println("勇者の行動を決めてください。(1: 攻撃, 2: 特殊行動, それ以外: 逃亡)");
        String input = scanner.nextLine();

        if (input.equals("1")) {
            // 攻撃だった場合
            AttackResult ret = hero.attack(enemy);
            System.out.println(enemy.getName() + "に" + ret.damage + "のダメージ");
            if (ret.state == AttackResult.BATTLE_END) {
                // 戦闘終了
                System.out.println(enemy.getName() + "を倒しました。ゲームクリア。");
                return false; // 続行不能
            }
            // 戻り値は、行動により戦闘続行可否をbooleanで返します
            return true;
        }else if(input.equals("2")) {
            //特殊行動だった場合
            IHeroJob job = (IHeroJob)hero;
            AttackResult ret = job.specialAttack(enemy);
            System.out.println(job.getSpecialAttackName() + "!!!");

            System.out.println(enemy.getName() + "に" + ret.damage + "のダメージ");
            if (ret.state == AttackResult.BATTLE_END) {
                // 戦闘終了
                System.out.println(enemy.getName() + "を倒しました。ゲームクリア。");
                return false; // 続行不能
            }
            // 戻り値は、行動により戦闘続行可否をbooleanで返します
            return true;
        }else {
            // 逃亡だった場合
            System.out.println(hero.getName() + "は逃亡しました。ゲームオーバー");
            return false; // 続行不能
        }
    }

    boolean enemyAction() {
        // 敵の1回分の攻撃行動を行わせるメソッド（敵は攻撃の行動のみ行います）
        // 攻撃だった場合
        AttackResult ret = enemy.attack(hero);
        System.out.println(hero.getName() + "に" + ret.damage + "のダメージ");
        if (ret.state == AttackResult.BATTLE_END) {
            // 戦闘終了
            System.out.println(hero.getName() + "は無残にも倒れてしまった。ゲームオーバー");
            return false; // 続行不能
        }
        // 戻り値は、行動により戦闘続行可否をbooleanで返します
        return true;
    }

    void battleLoop() {
        //戦闘処理の無限ループを用意します
        while(true) {
            // 無限ループ内では、勇者と敵の素早さを比較し行動順序を入れ替え、それぞれの行動を行います
            // 行動により戦闘続行不可能になった場合は、その場で無限ループを抜け、メソッドを終了します
            if (hero.getAgi() >= enemy.getAgi()) {
                // 勇者のほうが早い
                if (!heroAction()) return;
                if (!enemyAction()) return;
            } else {
                if (!enemyAction()) return;
                if (!heroAction()) return;
            }
        }
    }


    public static void main(String[] args) {
        SimpleRPG app = new SimpleRPG();


        app.hero = app.createHero();
        System.out.println(app.hero.toString());

        //武器装備
        Weapon weaponInstance = new Weapon("木の棒",3);
        app.hero.setWeapon(weaponInstance);
        System.out.println(app.hero.getWeapon().getName() + "を装備した。atk + " + app.hero.getWeapon().getAtk());
        app.hero.setAtk(app.hero.getAtk());//装備した武器のAtkを勇者のAtkに加算
        System.out.println(app.hero.toString());//装備後のステータス表示

        System.out.println("モンスターになった食べ物を倒してください。");
        app.enemy = app.createEnemy();
        System.out.println(app.enemy.toString());

        app.battleLoop();
    }


}
